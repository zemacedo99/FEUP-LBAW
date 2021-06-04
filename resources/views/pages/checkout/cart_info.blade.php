@extends('layouts.app')

@section('content')

<script src={{ asset('js/checkout.js') }} defer> </script>
@php
$user_id = \Illuminate\Support\Facades\Auth::id();
@endphp



<div class="container">
   
    <form action="/api/checkout" method="POST" id="form">
        @csrf
        <div class="col-12">

            <div class="row">
                <div class="row m-3"></div>
                <!-- Breadcrumb  -->
                <div class="d-flex justify-content-center">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" id="selectedLink" aria-current="page">Information</li>
                            <li class="breadcrumb-item" style="text-decoration: none; color: black;"> Shipping / Payment</li>
                        </ol>
                    </nav>
                </div>
                <div class="row m-3"></div>

            </div>

            
            <div class="col order-1">
                <div class="row" style='border-bottom:2px solid black;'>
                    <div class="col-6">
                        <h3 style='text-align:left;'>Order Summary</h3>
                    </div>
                    <div class="col-6">
                        <h3 style='text-align:right;'> {{sizeof($items)}} items in your cart</h3>
                        <input type="hidden" value="{{sizeof($items)}}" name="n_items">
                    </div>
                </div>
            </div>

            <div class="col order-6">
                <div class="row ">
                    @php
                        $i = 0;
                    @endphp

                    @foreach ($items as $item)
                    
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        @include('partials.cards.product_in_cart', [
                            'id' => $item->id,
                            'name' => $item->name,
                            'price' => $item->price,
                            'quantity' => $item->pivot->quantity,
                            'image' => $item->image,
                            'nr' => $i++,
                            ])
                        </div>

                    @endforeach
            
                </div>
            </div>

            <div class="row m-3"></div>

            <div class="row">

                <!-- Periodic Buys -->
                @include('partials.periodic')
                
                <!-- Coupons -->
                @include('partials.coupon_checkout')


            </div>


            <div class="col-12">
                <h4 style='text-align:center;' id ="total_price">Total: {{number_format($total,2)}}€</h4>
                <div class="row mb-3"></div>
            </div>


            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <input type="submit" class="btn btn-primary" value="Continue"> 
                </div>            
            </div>

        </div>
    </form>
</div>


@endsection