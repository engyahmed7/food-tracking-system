@extends('layouts.app')

@section('content')
<h1>Your Orders</h1>

@if(session('info'))
<p>{{ session('info') }}</p>
@endif

@if($orders->isEmpty())
<p>No orders found.</p>
@else
<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Status</th>
            <th>Total Amount</th>
            <th>Tracking</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->status }}</td>
            <td>${{ number_format($order->total_amount, 2) }}</td>
            <td>
                <a href="{{ route('order.track', ['order' => $order->id]) }}">Track Order</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection