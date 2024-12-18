<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PaymentProcessorFactoryInterface;
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

        $provider = $request->input('payment_method');


        $currency = 'USD';
        $amount = $request->input('total');
        $paymentMethodId = $request->input('payment_method_id');

        Log::info('Payment details', [
            'provider' => $provider,
            'currency' => $currency,
            'amount' => $amount,
            'payment_method_id' => $paymentMethodId,
        ]);

        Log::info('PayPal Configuration', [
            'mode' => config('services.paypal.mode'),
            'client_id_exists' => config('services.paypal.client_id'),
            'secret_exists' => config('services.paypal.secret'),
        ]);

        try {
            $paymentProcessor = $this->paymentProcessorFactory->getProcessor($provider);
            $details = [];
            if ($provider === 'stripe') {
                $details['payment_method_id'] = $paymentMethodId;
            }



            $response = $paymentProcessor->createPayment($amount, $currency, $details);
            Log::info('Payment response', ['response' => $response]);
            // dd($response);
            if ($response['status'] === 'success') {
                if ($provider === 'paypal') {
                    return redirect($response['approval_url']); 
                }
                return redirect()->route('payment.success')->with('client_secret', $response['client_secret']);
            } else {
                return redirect()->back()->with('error', $response['message']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Handle successful payment (e.g., after PayPal approval).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function paymentSuccess(Request $request)
    {
        return view('payment.success');
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
}
