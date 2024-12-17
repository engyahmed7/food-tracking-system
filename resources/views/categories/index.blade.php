@extends('layouts.app')

@section('content')
@include('layouts.header')

<div class="page-heading-shows-events">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Categories</h2>
                <span>Check out All Amazing Categories</span>
            </div>
        </div>
    </div>
</div>

<div class="tickets-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading">
                    <h2> Categories Page</h2>
                </div>
            </div>
            @foreach ($categories as $category)
            <div class="col-lg-4">
                <div class="ticket-item added-overlay item">
                    <a href="{{ route('category.show', $category->id) }}" class="thumb">
                        <img src="{{ asset('storage/' . $category->image) }}" class="prod-img-size" alt="" style="">
                    </a>
                    <a href="{{ route('category.show', $category->id) }}" class="category-overlay">
                        {{ $category->name }}
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

@include('layouts.footer')
@endsection