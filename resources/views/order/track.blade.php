@extends('layouts.app')
@section('content')
@include('layouts.header')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card order-tracking-card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">
                        <i class="fas fa-box-open me-2"></i>Order #{{ $order->id }}
                    </h2>
                    <span class="badge bg-light text-primary status-badge">
                        {{ $order->status }}
                    </span>
                </div>

                <div class="tracking-progress"></div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0">
                                <div class="card-header bg-light d-flex align-items-center">
                                    <i class="fas fa-receipt me-2 text-primary"></i>
                                    <h5 class="card-title mb-0">Order Summary</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Total Amount:</span>
                                        <strong class="text-success">${{ number_format($order->total_amount, 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0">
                                <div class="card-header bg-light d-flex align-items-center">
                                    <i class="fas fa-truck me-2 text-primary"></i>
                                    <h5 class="card-title mb-0">Delivery Tracking</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Status:</span>
                                        <span class="
                                                @if($order->deliveryTracking->status == 'Delivered') text-success 
                                                @elseif($order->deliveryTracking->status == 'In Transit') text-warning 
                                                @else text-secondary @endif">
                                            {{ $order->deliveryTracking->status ?? 'Not available' }}
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Address:</span>
                                        <span class="text-end">{{ $order->delivery_address }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Delivery Time:</span>
                                        <span>{{ $order->delivery_time }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($order->payment)
                    <div class="card border-0 bg-light">
                        <div class="card-header d-flex align-items-center">
                            <i class="fas fa-credit-card me-2 text-primary"></i>
                            <h5 class="card-title mb-0">Payment Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Payment Method:</span>
                                        <span>{{ $order->payment->payment_method }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Payment Status:</span>
                                        <span class="
                                                @if($order->payment->status == 'Paid') text-success 
                                                @elseif($order->payment->status == 'Pending') text-warning 
                                                @else text-danger @endif">
                                            {{ $order->payment->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card-footer text-center">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-life-ring me-2"></i>Need Help? Contact Support
                    </a>
                </div>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">
                    <i class="fas fa-shield-alt me-1"></i>Secure Order Tracking
                </small>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection


<style>
    body {
        background-color: #f4f6f9;
    }

    .order-tracking-card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-top: 4px solid #007bff;
    }

    .status-badge {
        font-size: 0.9rem;
        font-weight: 600;
    }

    .tracking-progress {
        height: 4px;
        background: linear-gradient(to right, #28a745 0%, #28a745 50%, #6c757d 50%, #6c757d 100%);
    }
</style>