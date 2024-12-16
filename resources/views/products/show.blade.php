@extends('layouts.app')

@section('title', 'Home - ArtXibition')

@section('content')

<body>

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

    @include('layouts.header')

    <!-- ***** About Us Page ***** -->
    <div class="page-heading-shows-events">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>
                        {{ $product->name }}
                    </h2>
                    <span>
                        {{ $product->description }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="ticket-details-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="left-image">
                        <img
                            class="img-fluid w-100"
                            style="height: 400px; object-fit: cover;"
                            src="
                            {{ asset('storage/' . $product->image) }}
                        " alt="{{ $product->name }}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-content">
                        <h4>
                            {{ $product->name }}
                        </h4>
                        <span>{{ $product->stock < 3 ? 'only '. $product->stock  : $product->stock }} still available</span>

                        <div class="quantity-content">
                            <div class="left-content">
                                <h6>Standard Price</h6>
                                <p>
                                    <span id="price">${{ $product->price }}</span>
                                </p>
                            </div>
                            <div class="right-content">
                                <div class="quantity buttons_added">
                                    <input type="button" value="-" class="minus" id="minusButton">
                                    <input type="number" step="1" min="1" name="quantity" value="1" title="Qty" class="input-text qty text" id="quantityInput" size="4" pattern="" inputmode="">
                                    <input type="button" value="+" class="plus" id="plusButton">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="stock" name="stock" value="{{ $product->stock }}">
                        <div class="total">
                            <h4 id="total" class="mb-2 col-12">Total: ${{ $product->price }}</h4>
                            <form method="POST" action="{{ route('cart.add') }}" class="main-dark-button" id="addToCartForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" id="hiddenQuantityInput" value="1">
                                <button type="submit">
                                    Add To Cart
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const minusButton = document.getElementById('minusButton');
            const plusButton = document.getElementById('plusButton');
            const quantityInput = document.getElementById('quantityInput');
            const hiddenQuantityInput = document.getElementById('hiddenQuantityInput');
            const priceElement = document.getElementById('price');
            const totalElement = document.getElementById('total');
            const stockElement = document.getElementById('stock');

            const updateTotal = () => {
                let quantity = parseInt(quantityInput.value) || 1;
                const price = parseFloat(priceElement.textContent.replace('$', ''));
                totalElement.textContent = `Total: $${(quantity * price).toFixed(2)}`;

                // if (quantity > stockElement.value) {
                //     quantityInput.value = stockElement.value; // Restrict to stock
                //     alert("Quantity exceeds available stock.");
                // }

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


</body>
@include('layouts.footer')
@endsection