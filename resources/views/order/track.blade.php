@extends('layouts.app')
@section('content')
@include('layouts.header')
<div class="order-tracking-wrapper">
    <div class="container-fluid px-4">
        <div class="order-header">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="order-title">
                        <i class="fas fa-box-open me-3"></i>Order Tracking
                        <span class="order-number">#{{ $order->id }}</span>
                    </h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <span class="status-badge-large">
                        <i class="fas fa-circle me-2"></i>{{ $order->status }}
                    </span>
                </div>
            </div>
        </div>

        <div class="tracking-timeline">
            <div class="timeline-step active">
                <div class="step-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="step-label">Order Placed</div>
            </div>
            <div class="timeline-connector active"></div>
            <div class="timeline-step active">
                <div class="step-icon"><i class="fas fa-check"></i></div>
                <div class="step-label">Confirmed</div>
            </div>
            <div class="timeline-connector"></div>
            <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-box"></i></div>
                <div class="step-label">Processed</div>
            </div>
            <div class="timeline-connector"></div>
            <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-truck"></i></div>
                <div class="step-label">In Transit</div>
            </div>
            <div class="timeline-connector"></div>
            <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-home"></i></div>
                <div class="step-label">Delivered</div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-8">
                <div class="info-grid">
                    <div class="info-card order-summary">
                        <div class="card-header-custom">
                            <i class="fas fa-receipt header-icon"></i>
                            <h3>Order Summary</h3>
                        </div>
                        <div class="card-content">
                            <div class="summary-item">
                                <span>Total Amount</span>
                                <span class="amount">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Order Date</span>
                                <span>{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Items</span>
                                <span>{{ $order->orderItems->count() }} items</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card delivery-info">
                        <div class="card-header-custom">
                            <i class="fas fa-truck header-icon"></i>
                            <h3>Delivery Information</h3>
                        </div>
                        <div class="card-content">
                            <div class="delivery-status">
                                <span class="status-label">Current Status</span>
                                <span class="status-value {{ strtolower($order->deliveryTracking->status) }}">
                                    {{ $order->deliveryTracking->status ?? 'Not available' }}
                                </span>
                            </div>
                            <div class="address-info">
                                <span class="info-label">Delivery Address</span>
                                <p class="info-value">{{ $order->delivery_address }}</p>
                            </div>
                            <div class="time-info">
                                <span class="info-label">Expected Delivery</span>
                                <span class="info-value">{{ $order->delivery_time }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                @if ($order->payment)
                <div class="info-card payment-info">
                    <div class="card-header-custom">
                        <i class="fas fa-credit-card header-icon"></i>
                        <h3>Payment Details</h3>
                    </div>
                    <div class="card-content">
                        <div class="payment-method">
                            <span class="info-label">Payment Method</span>
                            <span class="method-value">
                                <i class="fas fa-credit-card me-2"></i>
                                {{ $order->payment->payment_method }}
                            </span>
                        </div>
                        <div class="payment-status">
                            <span class="info-label">Status</span>
                            <span class="status-chip {{ strtolower($order->payment->payment_status) }}">
                                {{ $order->payment->payment_status }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif

                <div class="support-card">
                    <div class="support-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4>Need Assistance?</h4>
                    <p>Our support team is here to help you 24/7</p>
                    <a href="#" class="support-button">
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection

<style>
    body {
        background-color: #111111;
        color: #e0e0e0 !important;
        font-family: 'Inter', sans-serif;
    }

    .order-tracking-wrapper {
        color: #ffffff !important;
        padding: 2rem 0;
        min-height: 100vh;
    }

    .order-header {
        background: linear-gradient(145deg, #1a1a1a 0%, #2d2d2d 100%);
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 3rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .order-title {
        color: #ffffff;
        font-size: 2rem;
        font-weight: 600;
        margin: 0;
    }

    .order-number {
        color: #808080;
        font-size: 1.5rem;
        margin-left: 1rem;
    }

    .status-badge-large {
        background: rgba(64, 64, 64, 0.3);
        padding: 1rem 2rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 500;
        color: #00ff9d;
        backdrop-filter: blur(10px);
        display: inline-flex;
        align-items: center;
    }

    .tracking-timeline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 3rem 0;
        padding: 0 2rem;
    }

    .timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .step-icon {
        width: 50px;
        height: 50px;
        background: #2d2d2d;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        border: 2px solid #404040;
        transition: all 0.3s ease;
    }

    .timeline-step.active .step-icon {
        background: #00ff9d;
        border-color: #00ff9d;
    }

    .timeline-step.active .step-icon i {
        color: #111111;
    }

    .timeline-connector {
        flex-grow: 1;
        height: 3px;
        background: #404040;
        margin: 0 15px;
        position: relative;
        top: -25px;
    }

    .timeline-connector.active {
        background: #00ff9d;
    }

    .step-label {
        color: #808080;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .timeline-step.active .step-label {
        color: #00ff9d;
    }

    .info-grid {
        display: grid;
        gap: 1.5rem;
    }

    .info-card {
        background: #1a1a1a;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
    }

    .card-header-custom {
        background: #2d2d2d;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #404040;
    }

    .header-icon {
        font-size: 1.5rem;
        color: #00ff9d;
        margin-right: 1rem;
    }

    .card-header-custom h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff;
    }

    .card-content {
        padding: 1.5rem;
    }

    .summary-item,
    .delivery-status,
    .payment-method {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #2d2d2d;
    }

    .amount {
        font-size: 1.2rem;
        font-weight: 600;
        color: #00ff9d;
    }

    .status-value,
    .status-chip {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .status-value.delivered,
    .status-chip.paid {
        background: rgba(0, 255, 157, 0.1);
        color: #00ff9d;
    }

    .status-value.in-transit,
    .status-chip.pending {
        background: rgba(255, 215, 0, 0.1);
        color: #ffd700;
    }

    .info-label {
        color: #808080;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .info-value {
        color: #ffffff;
        font-weight: 500;
    }

    .support-card {
        background: linear-gradient(145deg, #2d2d2d 0%, #1a1a1a 100%);
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        margin-top: 1.5rem;
    }

    .support-icon {
        width: 60px;
        height: 60px;
        background: #404040;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .support-icon i {
        font-size: 1.5rem;
        color: #00ff9d;
    }

    .support-button {
        display: inline-block;
        background: #00ff9d;
        color: #111111;
        padding: 1rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 1.5rem;
        transition: all 0.3s ease;
    }

    .support-button:hover {
        background: #00cc7d;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 255, 157, 0.3);
    }

    @media (max-width: 768px) {
        .tracking-timeline {
            flex-direction: column;
            align-items: flex-start;
            padding: 0 1rem;
        }

        .timeline-step {
            flex-direction: row;
            width: 100%;
            margin-bottom: 1rem;
        }

        .timeline-connector {
            width: 3px;
            height: 30px;
            margin: 15px 0;
            position: absolute;
            left: 25px;
        }

        .step-label {
            margin-left: 1rem;
            margin-bottom: 0;
        }

        .order-header {
            text-align: center;
        }

        .status-badge-large {
            margin-top: 1rem;
        }
    }
</style>