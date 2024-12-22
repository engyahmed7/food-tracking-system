<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PaymentProcessorFactoryInterface;
use App\Models\Cart;
use App\Models\DeliveryTracking;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected PaymentProcessorFactoryInterface $paymentProcessorFactory;

    public function __construct(PaymentProcessorFactoryInterface $paymentProcessorFactory)
    {
        $this->paymentProcessorFactory = $paymentProcessorFactory;
    }

    /**
     * Handle payment creation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createPayment(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        $zoneId = $request->input('zone_id');
        Log::info('zoneId', ['zoneId' => $zoneId]);
        if (!$zoneId) {
            return redirect()->back()->with('error', 'Please select a shipping zone.');
        }

        $currency = 'USD';
        $amount = $request->input('total');

        if ($paymentMethod === 'cod' || $paymentMethod === 'paypal') {
            $paymentMethodId = '';
        } else {
            $paymentMethodId = $request->input('payment_method_id');
        }

        try {
            $paymentProcessor = $this->paymentProcessorFactory->getProcessor($paymentMethod);
            $details = $this->getPaymentDetails($paymentMethod, $paymentMethodId, $zoneId);

            $response = $paymentProcessor->createPayment($amount, $currency, $details);
            Log::info('Payment response', ['response' => $response]);

            return $this->handlePaymentResponse($response, $paymentMethod, $paymentMethodId, $zoneId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Handle successful payment.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function paymentSuccess(Request $request)
    {
        $existingOrder = Order::where('user_id', Auth::id())
            ->whereIn('status', ['paid', 'completed'])
            ->first();
        if ($existingOrder) {
            return response()->json(['message' => 'You have already placed an order.']);
        }


        $cart = $this->getUserCart();
        if (!$cart) {
            return response()->json(['message' => 'You have already placed an order.']);
        }

        $zoneId = $request->input('zone_id');
        Log::info('zoneId Payment Sucess', ['zoneId' => $zoneId]);
        if (!$zoneId) {
            return response()->json(['message' => 'Zone ID is missing.'], 400);
        }

        $order = $this->createOrderFromCart($cart, $request);
        $payment = $this->createPaymentRecord($order, $request);
        $this->createDeliveryTracking($order);
        $this->clearUserCart($cart);

        $this->decreaseProductStock($order);

        return view('order.track', ['order' => $order]);
    }

    private function decreaseProductStock(Order $order): void
    {
        foreach ($order->orderItems as $orderItem) {
            $product = $orderItem->product;
            $product->stock -= $orderItem->quantity;

            if ($product->stock < 0) {
                $product->stock = 0;
            }

            $product->save();
        }
    }
    /**
     * Handle failed payment.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function paymentFailed(Request $request)
    {
        return view('payment.failed');
    }

    /**
     * Get user cart.
     *
     * @return \App\Models\Cart|null
     */
    private function getUserCart()
    {
        return Cart::where('user_id', Auth::id())->first();
    }

    /**
     * Create an order from the cart items.
     *
     * @param \App\Models\Cart $cart
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\Order
     */
    private function createOrderFromCart(Cart $cart, Request $request): Order
    {
        $zoneId = $request->input('zone_id');
        $shippingRate = Zone::findOrFail($zoneId)->rates()->first()->rate;
        $totalAmount = $cart->items->sum(fn($item) => $item->product->price * $item->quantity) + $shippingRate;

        $order = new Order();
        $order->user_id = Auth::id();
        $order->total_amount = $totalAmount;
        $order->status = 'pending';
        $order->payment_status = 'paid';
        $order->delivery_address = $request->input('delivery_address', '');
        $order->delivery_time = $request->input('delivery_time');
        $order->shipping_fee = $shippingRate;
        $order->save();

        $this->addItemsToOrder($order, $cart);

        return $order;
    }

    /**
     * Add items from cart to order.
     *
     * @param \App\Models\Order $order
     * @param \App\Models\Cart $cart
     * @return void
     */
    private function addItemsToOrder(Order $order, Cart $cart): void
    {
        foreach ($cart->items as $cartItem) {
            $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }
    }

    /**
     * Create a payment record for the order.
     *
     * @param \App\Models\Order $order
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\Payment
     */
    private function createPaymentRecord(Order $order, Request $request): Payment
    {
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->payment_method = $request->input('payment_method');
        $payment->payment_status = $this->getPaymentStatus($payment->payment_method);
        $payment->save();

        return $payment;
    }

    /**
     * Get the payment status based on the payment method.
     *
     * @param string $paymentMethod
     * @return string
     */
    private function getPaymentStatus(string $paymentMethod): string
    {
        return ($paymentMethod === 'stripe' || $paymentMethod === 'paypal') ? 'completed' : 'pending';
    }

    /**
     * Create delivery tracking for the order.
     *
     * @param \App\Models\Order $order
     * @return void
     */
    private function createDeliveryTracking(Order $order): void
    {
        $deliveryTracking = new DeliveryTracking();
        $deliveryTracking->order_id = $order->id;
        $deliveryTracking->status = 'preparing';
        $deliveryTracking->save();
    }

    /**
     * Clear items from cart after order is placed.
     *
     * @param \App\Models\Cart $cart
     * @return void
     */
    private function clearUserCart(Cart $cart): void
    {
        $cart->items()->delete();
        $cart->delete();
    }

    /**
     * Handle payment response.
     *
     * @param array $response
     * @param string $paymentMethod
     * @param string $paymentMethodId
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handlePaymentResponse(array $response, string $paymentMethod, string $paymentMethodId, string $zoneId)
    {
        if ($response['status'] === 'success') {
            if ($paymentMethod === 'paypal') {
                return redirect($response['approval_url']);
            }
            return redirect()->route('payment.success', [
                'payment_method' => $paymentMethod,
                'payment_method_id' => $paymentMethodId,
                'zone_id' => $zoneId,
            ]);
        }

        return redirect()->back()->with('error', $response['message']);
    }

    /**
     * Get payment details based on the payment method.
     *
     * @param string $paymentMethod
     * @param string $paymentMethodId
     * @return array
     */
    private function getPaymentDetails(string $paymentMethod, string $paymentMethodId, string $zoneId): array
    {
        return ($paymentMethod === 'stripe') ? ['payment_method_id' => $paymentMethodId] : [];
    }
}
