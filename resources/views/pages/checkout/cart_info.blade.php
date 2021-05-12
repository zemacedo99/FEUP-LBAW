@extends('layouts.app')

@section('content')

<script type="text/javascript" src={{ asset('js/checkout.js') }} defer> </script>
@php
$user_id = \Illuminate\Support\Facades\Auth::id();
@endphp

<div class="container">
   
    <form action="/api/checkout" method="POST" id="form" required>
        
    <div class="col-12">

        <div class="row">
            <div class="row m-3"></div>
            <!-- Breadcrumb  -->
            <div class="d-flex justify-content-center">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" id="selectedLink" aria-current="page">Information</li>
                        <li class="breadcrumb-item"><a href="{{route('payment', ['id' => $user_id ])}}" style="text-decoration: none; color: black;">Shipping / Payment</a></li>
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
            <input type="hidden" id="periodic" value="SingleBuy">

            <div class="col-12 col-lg-12 order-2">
                <div class="row">

                    <div class="col"></div>

                    <div class="col-12 col-lg-12">

                        <div class="row">
                            <h3 style='text-align:left;border-bottom:2px solid black;'>Periodic Buys <button type="button" class="simpleicon">history</button></h3>
                        </div>

                        <div class="row mb-3"></div>

                        <div class="row">

                            <ul class="nav nav-pills mb-3 d-flex justify-content-evenly" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <label for="male" data-bs-toggle="pill" data-bs-target="#pills-once" name="SingleBuy" class="periodic" >Once</label>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <label for="male" data-bs-toggle="pill" data-bs-target="#pills-daily" name="Day" class="periodic" >Daily</label>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <label for="female" data-bs-toggle="pill" data-bs-target="#pills-weekly" name="Week" class="periodic" >Weekly</label>
                                </li>
                                <li class="nav-item" role="presentation"> 
                                    <label for="other" data-bs-toggle="pill" data-bs-target="#pills-monthly" name="Month" class="periodic" >Monthly</label>
                                </li>
                            </ul>

                            <div class="row mb-3"></div>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade text-center" id="pills-once" role="tabpanel" aria-labelledby="pills-once-tab">One time purchase</div>
                                <div class="tab-pane fade text-center" id="pills-daily" role="tabpanel" aria-labelledby="pills-daily-tab">Daily purchase the products in this cart</div>
                                <div class="tab-pane fade text-center" id="pills-weekly" role="tabpanel" aria-labelledby="pills-weekly-tab">
                                    <input type="radio" id="monday" name="gender" value="monday" class="d-none">
                                    <label for="monday">Monday</label><br>
                                    <input type="radio" id="tuesday" name="gender" value="tuesday" class="d-none">
                                    <label for="tuesday">Tuesday</label><br>
                                    <input type="radio" id="wednesday" name="gender" value="wednesday" class="d-none">
                                    <label for="wednesday">Wednesday</label><br>
                                    <input type="radio" id="thursday" name="gender" value="thursday" class="d-none">
                                    <label for="thursday">Thursday</label><br>
                                    <input type="radio" id="friday" name="gender" value="friday" class="d-none">
                                    <label for="friday">Friday</label><br>
                                    <input type="radio" id="saturday" name="gender" value="saturday" class="d-none">
                                    <label for="saturday">Saturday</label><br>
                                    <input type="radio" id="sunday" name="gender" value="sunday" class="d-none">
                                    <label for="sunday">Sunday</label><br>
                                </div>
                                <div class="tab-pane fade text-center" id="pills-monthly" role="tabpanel" aria-labelledby="pills-monthly-tab">
                                    <label for="festa">Choose the day of the next delivery <br> All of the next deliveries will occur on the same day monthly</label>
                                    <div class="col-12 d-flex justify-content-center mt-2">
                                        <input type="date" id="festa" name="festa" min="<?= date('Y-m-d') ?>" max="<?php $dt2 = new DateTime("+1 month");
                                                                                                                    $date = $dt2->format("Y-m-d");
                                                                                                                    echo $date ?>" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col"></div>
                    <div class="row m-3"></div>
                </div>
            </div>

            <!-- Coupons -->
            <div class="col-12  col-lg-12 order-3">

                <div class="row">

                    <div class="col"></div>

                    <div class="col-12 col-lg-12">

                        <div class="row">
                            <h3 style='text-align:left;border-bottom:2px solid black;'>Coupons <button type="button" class="simpleicon" >redeem</button></h3>
                        </div>

                        <div class="row mt-3"></div>

                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="CODE" id="coupon_code">
                                <small id="coupon_alert" class="text-danger"></small>
                            </div>
                            <div class="col-3 text-center">
                                <button type="button" class="simpleicon" id="addCoupon">add</button>
                            </div>
                        </div>

                        <div class="row mt-3"></div>

                        <div class="row row-cols-1 row-cols-md-2 g-4" id="coupons_list">
                            {{-- @include('partials.cards.coupon')
                            @include('partials.cards.coupon') --}}
                        </div>

                        <div class="row m-3"></div>

                    </div>
                    <div class="col"></div>

                    <div class="row m-3"></div>
                </div>
            </div>


        </div>


        <div class="col-12">
            <h4 style='text-align:center;' id ="total_price">Total: {{$total}}€</h4>
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