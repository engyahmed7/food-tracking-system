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
                    <!-- <h2>Your Cart</h2> -->
                </div>
            </div>

            <div class="col-lg-8">
                @if(count($cartItems) > 0)
                <ul>
                    @foreach($cartItems as $item)
                    <li class="cart-item">
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
                                    <form action="{{ route('cart.update') }}" class="" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                        <div class="quantity buttons_added">
                                            <input type="button" value="-" class="minus">
                                            <input type="number" step="1" min="1" max="10" name="quantity" value="{{ $item->quantity }}" class="input-text qty text" size="4">
                                            <input type="button" value="+" class="plus">
                                        </div>
                                        <button type="submit" class="mt-2 main-dark-button mb-5">Update</button>
                                    </form>
                                </div>
                                <div class="total">
                                    <h5>Price: ${{ number_format($item->product->price * $item->quantity, 2) }}</h5>
                                </div>
                            </div>

                            <form action="{{ route('cart.remove') }}" method="POST" class="remove-btn-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                <button type="submit" class="remove-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                <p>Your cart is empty. Add some items to your cart.</p>
                @endif
            </div>


            <div class="col-lg-4">
                <div class="right-content">
                    @if(count($cartItems) > 0)
                    <div class="total">
                        <h4>Total: ${{ number_format($cartItems->sum(function ($item) {
                                return $item->product->price * $item->quantity;
                            }), 2) }}</h4>
                        <a href="{{ route('checkout.index')}}" class="main-dark-button" id="payment-submit">Proceed to checkout</a>
                    </div>
                    @else
                    <div class="warn">
                        <p>*Add some items to your cart before proceeding to checkout.</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>


@include('layouts.footer')
@endsection