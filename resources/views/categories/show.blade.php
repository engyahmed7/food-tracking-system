@extends('layouts.app')
@section('content')
@include('layouts.header')

<div class="page-heading-rent-venue">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>{{ $category->name }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="shows-events-schedule">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>{{ $category->name }} Category</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <ul>
                    @if($category && $products)
                    @foreach($products as $product)

                    <li>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="title">
                                    <h4>{{ $product->name }}</h4>
                                    <span>{{ $product->stock }} Available</span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="time"><span> Sep 16, 2021<br>18:00 to 22:00</span></div>
                            </div>
                            <div class="col-lg-3">
                                <div class="place"><span><i class="fa-solid fa-dollar-sign"></i><span>{{ $product->price }}</span></div>
                            </div>
                            <div class="col-lg-3">
                                <div class="main-dark-button">
                                    <a href="{{ route('product.show', $product->id) }}
                                    ">View Details</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            {{ $products->links('vendor.pagination.custom') }}

        </div>
    </div>
</div>

@include('layouts.footer')
@endsection