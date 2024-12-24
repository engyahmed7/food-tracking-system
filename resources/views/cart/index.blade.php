@extends('layouts.app')

@section('content')
@include('layouts.header')

<!-- ***** Preloader Start ***** -->
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
                <h2>Your Cart</h2>
                <span>Review your selected items and proceed to purchase.</span>
            </div>
        </div>
    </div>
</div>

<div class="shows-events-schedule">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                </div>
            </div>

            <div class="col-lg-8">
                @if(count($cartItems) > 0)
                <form action="{{ route('cart.update') }}" method="POST" id="cartForm">
                    @csrf
                    <ul>
                        @foreach($cartItems as $index => $item)
                        <li class="cart-item position-relative">
                            <div class="row align-items-center">
                                <div class="col-lg-3">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid">
                                </div>
                                <div class="col-lg-6">
                                    <div class="title">
                                        <h4>{{ $item->product->name }}</h4>
                                        <span class="lead">${{ $item->product->price }} per item.</span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="quantity-content">
                                        <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product->id }}">
                                        <div class="quantity buttons_added">
                                            <input type="button" value="-" class="minus">
                                            <input type="number" step="1" min="1" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" class="input-text qty text" size="4">
                                            <input type="button" value="+" class="plus">
                                        </div>
                                    </div>
                                    <div class="total">
                                        <h5>Price: ${{ number_format($item->product->price * $item->quantity, 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="remove-btn" onclick="removeItem({{ $item->product->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                </svg>
                            </button>
                        </li>
                        @endforeach
                    </ul>
                    <button type="submit" class="main-dark-button mt-3">Update Cart</button>
                </form>

                <form id="removeForm" action="{{ route('cart.remove') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="product_id" id="removeProductId">
                </form>
                @else
                <p>Your cart is empty. Add some items to your cart.</p>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="cart-summary">
                    @if(count($cartItems) > 0)
                    <div class="summary-content">
                        <div class="summary-header">
                            <h3>Cart Summary</h3>
                        </div>

                        <div class="price-details">
                            <div class="subtotal">
                                <span>Subtotal</span>
                                <span>${{ number_format($cartItems->sum(function ($item) {
                                    return $item->product->price * $item->quantity;
                                }), 2) }}</span>
                            </div>

                            <div class="total">
                                <span>Total</span>
                                <span class="total-amount">${{ number_format($cartItems->sum(function ($item) {
                                    return $item->product->price * $item->quantity;
                                }), 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index')}}" class="main-dark-button checkout-btn text-center" id="payment-submit">
                            <span class="">Proceed to Checkout</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    @else
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Your cart is empty</p>
                        <span>Add some items to proceed to checkout</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.buttons_added').forEach(wrapper => {
            const input = wrapper.querySelector('.qty');
            const minusBtn = wrapper.querySelector('.minus');
            const plusBtn = wrapper.querySelector('.plus');

            minusBtn.addEventListener('click', () => {
                const currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    input.dispatchEvent(new Event('change'));
                }
            });

            plusBtn.addEventListener('click', () => {
                const currentValue = parseInt(input.value);
                input.value = currentValue + 1;
                input.dispatchEvent(new Event('change'));
            });

            input.addEventListener('change', () => {
                if (input.value < 1) {
                    input.value = 1;
                }
            });
        });
    });

    function removeItem(productId) {
        document.getElementById('removeProductId').value = productId;
        document.getElementById('removeForm').submit();
    }
</script>
<style>
    .cart-item {
        position: relative;
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .remove-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        padding: 5px;
        cursor: pointer;
        transition: transform 0.2s;
        z-index: 10;
    }

    .remove-btn:hover {
        transform: scale(1.1);
        color: #dc3545;
    }

    .cart-summary {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 25px;
    }

    .summary-header {
        border-bottom: 2px solid #f5f5f5;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .summary-header h3 {
        font-size: 24px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }

    .price-details {
        margin-bottom: 25px;
    }

    .subtotal,
    .total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
    }

    .total {
        border-top: 2px solid #f5f5f5;
        margin-top: 10px;
        padding-top: 20px;
    }

    .total-amount {
        font-size: 24px;
        font-weight: 700;
        color: #2c3e50;
    }

    .checkout-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        color: white;
        width: 100%;
        padding: 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }

    .empty-cart {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-cart i {
        font-size: 48px;
        color: #cbd5e0;
        margin-bottom: 15px;
    }

    .empty-cart p {
        font-size: 20px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .empty-cart span {
        color: #718096;
        font-size: 14px;
    }
</style>

@include('layouts.footer')
@endsection