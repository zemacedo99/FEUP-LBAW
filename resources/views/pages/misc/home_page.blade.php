@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-12 col-md-10">
                <img class="img-fluid" src="{{ asset('storage/garden_remake.jpg') }}" alt="Photo of a garden" height="400">
            </div>
        </div>

        @include('partials.product_row', ['name'=>"Almost Sold Out", 'icon'=>"clock", 'items'=> $items["almostSoldOut"]])
        @include('partials.product_row', ['name'=>"Hot", 'icon'=>"sun", 'items'=> $items["hot"]])
        @include('partials.product_row', ['name'=>"New", 'icon'=>"newspaper", 'items'=> $items["new"]])

        <div class="row my-5">
            <div class="col"></div>
            <div class="col-6 col-md-4 col-lg-3 text-end">
                <a href="/items" class="link-secondary">See all products<i class="bi bi-arrow-right-short"></i></a>
            </div>
        </div>
    </div>

@endsection
