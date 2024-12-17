@extends('layouts.app')

@section('content')
@include('layouts.header')

<div class="page-heading-shows-events">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Products</h2>
                <span>Check out All Amazing Products</span>
            </div>
        </div>
    </div>
</div>

<div class="tickets-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading">
                    <h2> Product Page</h2>
                </div>
            </div>
            @foreach ($products as $product)
            @if($product->stock > 0)
            <div class="col-lg-4">
                <div class="ticket-item">
                    <div class="thumb">
                        <img src="{{ asset('storage/' . $product->image) }}" class="prod-img-size" alt="" style="">
                    </div>
                    <div class="down-content">

                        <span>There Are {{ $product->stock }} Left For This Item</span>
                        <h4>Wonderful Festival</h4>
                        <div class="quantity-content">

                            <div class="right-content d-flex justify-content-between align-content-center align-items-center">
                                <div class="quantity buttons_added">
                                    <input type="button" value="-" class="minus" id="minusButton">
                                    <input type="number" step="1" min="1" name="quantity" value="1" title="Qty" class="input-text qty text" id="quantityInput" size="4" pattern="" inputmode="">
                                    <input type="button" value="+" class="plus" id="plusButton">
                                </div>

                                <div class="price">
                                    <span>
                                        <em> ${{ $product->price }} </em>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="stock" name="stock" value="{{ $product->stock }}">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" id="hiddenQuantityInput" value="1">
                            <button type="submit"
                                class="main-dark-button">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @endforeach

            {{ $products->links('vendor.pagination.custom') }}

        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const minusButton = document.getElementById('minusButton');
        const plusButton = document.getElementById('plusButton');
        const quantityInput = document.getElementById('quantityInput');
        console.log(quantityInput);
        const hiddenQuantityInput = document.getElementById('hiddenQuantityInput');
        const stockElement = document.getElementById('stock');

        const updateTotal = () => {
            let quantity = parseInt(quantityInput.value) || 1;
            console.log(quantity);

            hiddenQuantityInput.value = quantity;
        };

        minusButton.addEventListener('click', () => {
            let quantity = parseInt(quantityInput.value) || 1;
            if (quantity > 1) {
                quantityInput.value = --quantity;
                updateTotal();
            }
        });

        plusButton.addEventListener('click', () => {
            let quantity = parseInt(quantityInput.value) || 1;
            if (quantity < stockElement.value) {
                quantityInput.value = ++quantity;
                updateTotal();
            }
        });

        quantityInput.addEventListener('input', () => {
            let quantity = parseInt(quantityInput.value);
            if (isNaN(quantity) || quantity < 1) {
                quantityInput.value = 1;
            }
            updateTotal();
        });
    });
</script>

@include('layouts.footer')
@endsection