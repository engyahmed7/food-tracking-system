@extends('layouts.app')

@section('title', 'Home - ArtXibition')

@section('content')
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
<!-- ***** Main Banner Area Start ***** -->
<div class="main-banner">

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-content">
                    <h3>
                        {{ $bannerSettings->banner_text ?? $product->name ?? 'Discover Amazing Art Exhibitions' }}
                    </h3>
                    <h2>{{ $bannerSettings->banner_description?? $product->description ??  'Discover Amazing Art Exhibitions' }}</h2>
                    <div class="main-white-button">
                        <a href="{{ isset($product) ? route('product.show', $product->id) : '#' }}" class="btn btn-primary">
                            <i class="fa fa-shopping-cart me-2"></i>
                            {{ isset($product) ?  $bannerSettings->banner_btn_text : 'Order Now' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Main Banner Area End ***** -->

<!-- *** Owl Carousel Items ***-->
<div class="show-events-carousel">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-show-events owl-carousel">
                    @foreach($categories as $category)
                    <div class="item">
                        <a href="{{ route('category.show', $category->id) }}">
                            <img src="{{ asset('storage/'.$category->image) }}" alt="">
                        </a>
                        <a href="{{ route('category.show', $category->id) }}" class="category-overlay">
                            {{ $category->name }}
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


<!-- *** Amazing Venus ***-->
<div class="amazing-venues">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="left-content">
                    <h4>Discover Our Amazing Food Venues</h4>
                    <p>Our eCommerce platform offers a variety of venues for food-related events. Whether you're looking to host a cooking class, a food tasting, or a farmers' market, we have the perfect venue for you.</p>
                    <br>
                    <p>Explore our venues and find the perfect spot for your next food event. If you have any questions or need assistance, please visit our <a href="" target="_blank">Contact page</a>.</p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="right-content">
                    <h5><i class="fa fa-map-marker"></i> Visit Us</h5>
                    <span>123 Food St, <br>Gourmet City, FC 12345<br>United States</span>
                    <div class="text-button"><a href="">Need Directions? <i class="fa fa-arrow-right"></i></a></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- *** Venues & Tickets ***-->
<div class="venue-tickets">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Best Selling</h2>
                </div>
            </div>

            @if(count($featuredProducts) == 0)
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>No products available</h2>
                </div>
            </div>
            @else
            @foreach ($featuredProducts as $product)
            <div class="col-lg-4">
                <div class="venue-item">
                    <div class="thumb">
                        <img src="{{ asset('storage/'.$product->image) }}" alt="">
                    </div>
                    <div class="down-content">
                        <div class="left-content">
                            <div class="main-white-button">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <button class="main-dark-button" type="submit">Order Now</button>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                </form>
                            </div>
                        </div>
                        <div class="right-content">
                            <h4>{{ $product->name }}</h4>
                            <p>{{ $product->description }}</p>
                            <ul>
                                <li><i class="fa fa-sitemap"></i>{{ $product->stock }}</li>
                                <li><i class="fa fa-tags"></i>{{ $product->category->name }}</li>
                            </ul>
                            <div class="price">
                                <span> <em>${{ $product->price }}</em></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif

        </div>
    </div>
</div>


<!-- *** Coming Events ***-->
<div class="coming-events">
    <div class="left-button">
        <div class="main-white-button">
            <a class="" href="shows-events.html">Discover More</a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @if(count($recentFeaturedProducts) == 0)
            <div class="col-lg-12">
                <div class="section-heading">
                    <h4>No upcoming events</h4>
                </div>
            </div>
            @else
            @foreach($recentFeaturedProducts as $product)
            <div class="col-lg-4">
                <div class="event-item h-100"> <!-- Added h-100 class -->
                    <div class="thumb">
                        <a href="{{ route('product.show', $product->id) }}">
                            <img src="{{ asset('storage/'.$product->image) }}" alt="" class="img-fluid" style="height: 250px; object-fit: cover; width: 100%;">
                        </a>
                    </div>
                    <div class="down-content">
                        <a href="{{ route('product.show', $product->id) }}">
                            <h4 class="text-truncate">{{ $product->name }}</h4>
                        </a>
                        <ul>
                            <li><i class="fa fa-clock-o"></i> {{ $product->created_at->format('d M, Y') }}</li>
                            <li><i class="fa fa-map-marker"></i> {{ $product->category->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>

</div>


@include('layouts.footer')
@endsection