@extends('layouts.app')

@section('content')


<div class="container">

    <div class="row mt-3"></div>
    <div class="row mt-3"></div>

    <div class="row ">
        <div class="col-12 col-lg-5">

            <div class="row d-flex justify-content-center mb-3">
                <div class="col-12 col-lg-6" style="width: 15rem;">
                    <img src="{{ asset('storage/images/'.$image->path) }}" class="rounded-circle img-fluid">
                </div>
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center justify-content-lg-start">
                    <p class="col-md-auto text-decoration-underline text-center">
                    <h3>{{$name}}</h3>
                    </p>
                    
                </div>

            </div>
            <a href="{{ route('supplierProfile'  , ['id' => \Illuminate\Support\Facades\Auth::id()]) }}" class="link-dark" style='text-align:right;'>Back to profile</a>

        </div>
    </div>

    <div class="row mt-3"></div>
    <div class="row mt-3"></div>

    <h3> All Products </h3>


    <div class="row mt-3"></div>
    <div class="row mt-3"></div>
    <div class="row mt-3"></div>

    <!-- List of all products that a store have -->
    <div class="row  g-4">

        @foreach ($items as $item)
            @php
            $data = 
            [
                'is_bundle' => $item->is_bundle,
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'description' => $item->description,
                'unit' => $item->unit,
                'images' => $item->images,
            ];
            @endphp
            @include('partials.cards.product_detail_supplier',$data)
        @endforeach

        <div class="row mt-3"></div>
        <div class="row mt-3"></div>
        @include('partials.pages',['link'=>"supplier_all_products",'paginator'=>$items])

    </div>

    

</div>

@endsection