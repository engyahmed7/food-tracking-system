@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- ***** Preloader End ***** -->

<div class="page-heading-rent-venue">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Checkout</h2>
                <span>Review your selected items and proceed to payment.</span>
            </div>
        </div>
    </div>
</div>
<div class="checkout-container py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Cart Items -->
            <div class="col-lg-5">
                <div class="cart-items-enhanced">
                    @foreach($cartItems as $item)
                    <div class="cart-item-card">
                        <div class="cart-item-image">
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                            <div class="item-quantity-badge">{{ $item->quantity }}</div>
                        </div>
                        <div class="cart-item-details">
                            <div class="cart-item-header">
                                <h5>{{ $item->product->name }}</h5>
                                <span class="item-price">${{ number_format($item->product->price, 2) }}</span>
                            </div>
                            <div class="cart-item-footer">
                                <div class="item-total">
                                    <span class="label">Total:</span>
                                    <span class="amount">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Checkout Form -->
            <div class="col-lg-7">
                <div class="checkout-box bg-white shadow-sm rounded p-4">
                    <form id="payment-form" action="{{ route('payment.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="total" value="{{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}">
                        <input type="hidden" name="payment_method_id" id="payment_method_id">

                        <div class="payment-methods mb-4">
                            <h4 class="fw-bold mb-3">Select Payment Method</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="payment-card border rounded p-3 text-center hover-shadow">
                                        <input type="radio" name="payment_method" id="stripe" value="stripe" required>
                                        <label for="stripe" class="d-block mt-2">
                                            <i class="bi bi-credit-card fs-3"></i>
                                            <span>Credit/Debit Card</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-card border rounded p-3 text-center hover-shadow">
                                        <input type="radio" name="payment_method" id="paypal" value="paypal" required>
                                        <label for="paypal" class="d-block mt-2">
                                            <i class="bi bi-paypal fs-3"></i>
                                            <span>PayPal</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-card border rounded p-3 text-center hover-shadow">

                                        <input type="radio" name="payment_method" id="cod" value="cod" required>
                                        <label for="cod" class="d-block mt-2">
                                            <i class="bi bi-cash fs-3"></i>
                                            <span>Cash on Delivery</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="stripe-payment-method" class="mt-3" style="display: none;">
                            <div id="card-element" class="form-control"></div>
                            <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                        </div>

                        <script src="https://js.stripe.com/v3/"></script>
                        <script>
                            const stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY') }}');
                            const elements = stripe.elements();
                            const card = elements.create('card');
                            card.mount('#card-element');

                            const paymentForm = document.getElementById('payment-form');
                            const paymentMethodInput = document.getElementById('payment_method_id');
                            const stripePaymentMethod = document.getElementById('stripe-payment-method');

                            paymentForm.addEventListener('submit', async (event) => {
                                event.preventDefault();

                                const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

                                if (paymentMethod === 'stripe') {
                                    const {
                                        paymentMethod,
                                        error
                                    } = await stripe.createPaymentMethod({
                                        type: 'card',
                                        card: card,
                                    });

                                    if (error) {
                                        document.getElementById('card-errors').textContent = error.message;
                                    } else {
                                        paymentMethodInput.value = paymentMethod.id;
                                        paymentForm.submit();
                                    }
                                } else {
                                    paymentForm.submit();
                                }
                            });

                            document.querySelectorAll('input[name="payment_method"]').forEach((input) => {
                                input.addEventListener('change', (event) => {
                                    if (event.target.value === 'stripe') {
                                        stripePaymentMethod.style.display = 'block';
                                    } else {
                                        stripePaymentMethod.style.display = 'none';
                                    }
                                });
                            });
                        </script>

                        <div class="checkout-total mt-4">
                            <h4 class="fw-bold">Total Amount</h4>
                            <p class="fs-5">${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</p>
                        </div>

                        <button type="submit" id="payment-submit" class="btn w-100 mt-3 py-2">
                            Proceed to Pay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    :root {
        --primary-color: #6a11cb;
        --secondary-color: #2575fc;
        --background-color: #f4f6f9;
        --text-color: #333;
        --border-radius: 10px;
        --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }



    .checkout-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 30px;
        margin-top: 50px;
    }

    .cart-items {
        background-color: #f8f9fa;
        border-radius: var(--border-radius);
        padding: 20px;
    }

    .btn {
        background-color: black;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #f4f6f9;
        color: black;
        border: 2px solid black;
    }

    .cart-item {
        background-color: white;
        border-radius: var(--border-radius);
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .cart-item:hover {
        transform: translateY(-5px);
    }

    .payment-card {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius);
        padding: 15px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .payment-card input[type="radio"] {
        display: none;
    }

    .payment-card label {
        cursor: pointer;
        display: block;
        color: #6c757d;
    }

    .payment-card input[type="radio"]:checked+label,
    .payment-card:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .payment-card i {
        font-size: 2.5rem;
        margin-bottom: 10px;
        transition: color 0.3s ease;
    }

    .checkout-btn {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
        color: white;
        padding: 12px 25px;
        border-radius: var(--border-radius);
        transition: transform 0.3s ease;
    }

    .checkout-btn:hover {
        transform: scale(1.05);
        background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
    }

    #stripe-payment-method {
        background-color: #f1f3f5;
        border-radius: var(--border-radius);
        padding: 15px;
    }

    .checkout-header h2 {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .checkout-header p {
        font-size: 1.2rem;
        color: #6c757d;
    }

    .checkout-total h4 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .checkout-total p {
        font-size: 1.2rem;
        color: var(--primary-color);
    }

    .cart-items-enhanced {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
    }

    .cart-item-card {
        display: flex;
        align-items: center;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .cart-item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .cart-item-image {
        position: relative;
        width: 100px;
        height: 100px;
        margin-right: 15px;
    }

    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-quantity-badge {
        position: absolute;
        top: 1px;
        right: -10px;
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
    }

    .cart-item-details {
        flex-grow: 1;
        padding: 15px;
    }

    .cart-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .cart-item-header h5 {
        margin: 0;
        color: #333;
        font-weight: 600;
    }

    .item-price {
        font-weight: bold;
        color: #6a11cb;
    }

    .cart-item-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .item-total {
        display: flex;
        align-items: center;
    }

    .item-total .label {
        margin-right: 10px;
        color: #6c757d;
    }

    .item-total .amount {
        font-weight: bold;
        color: #28a745;
    }
</style>
@include('layouts.footer')
@endsection