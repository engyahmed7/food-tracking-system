<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    public function calculateShipping(Request $request)
    {
        $zoneId = $request->input('zone_id');
        $zone = Zone::findOrFail($zoneId);

        $cartTotal = $request->input('total');
        $shippingRate = $zone->rates()->first()->rate;

        $totalWithShipping = $cartTotal + $shippingRate;

        return response()->json([
            'cart_total' => $cartTotal,
            'shipping_rate' => $shippingRate,
            'total_with_shipping' => $totalWithShipping,
        ]);
    }

    public function confirmOrder(Request $request)
    {
        $zoneId = $request->input('zone_id');
        $shippingRate = Zone::findOrFail($zoneId)->rates()->first()->rate;

        $order = Order::create([
            'user_id' => Auth::id(),
            'cart_total' => $request->input('cart_total'),
            'shipping_fee' => $shippingRate,
            'total' => $request->input('total') + $shippingRate,
            'status' => 'pending',
        ]);

        return redirect()->route('order.track', ['order' => $order->id]);
    }
}
