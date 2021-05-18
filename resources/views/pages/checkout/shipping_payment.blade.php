@extends('layouts.app')

@section('content')

@php
    $user_id = \Illuminate\Support\Facades\Auth::id();
@endphp

<script type="text/javascript" src={{ asset('js/payment.js') }} defer> </script>

<div class="container">

    <div class="col-12">
        <div class="row">

            <div class="row m-3"></div>
            <!-- Breadcrumb  -->
            <div class="d-flex justify-content-center">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" style="text-decoration: none; color: black;">Information</li>
                        <li class="breadcrumb-item active" id="selectedLink" aria-current="page">Shipping / Payment</li>
                    </ol>
                </nav>
            </div>
            <div class="row m-3"></div>

            <form action="/api/payment" method="POST" id="form">
                @csrf
            <div class="row">

                <!-- <div class="col"></div> -->

                <!-- ****************** Left Side ****************** -->
               @include('partials.ship_details', ['sd' => $sd])


                <div class="col-lg-1"></div>

                <!-- ****************** Right Side ****************** -->
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">

                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>

                    <div class="col-12">
                        <h3 class="mb-3 " style='text-align:left;border-bottom:2px solid black;'>Payment Information</h3>

                        @include('partials.cards.credit_card', ['ccs' => $ccs])

                        <div class="card mb-3 d-flex justify-content-center align-items-center" style="height: 60px;">
                            <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#addCard"></a>
                            <p class="card-text">Add new Card <i class="bi bi-plus"></i></p>
                        </div>
                    
                        @include('partials.modals.add_credit_card')

                    </div>
                    <small id="cc_alert" class="text-danger"></small>
                </div>
            </div>

            <div class="row m-3"></div>
            
            <div class="col-12">

                <h4 style='text-align:center;'>Total: {{$total}}€</h4>
                <div class="row mb-3"></div>
        
            </div>


            <div class="col-12">
                <div class="row">

                    <div class="d-flex justify-content-center">
                        <input type="submit" class="btn btn-primary" value="Finish">
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="d-flex justify-content-center">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">THANKS!</h5>
                            </div>
                        </div>
                        <div class="modal-body text-center">
                            Success <br>
                            Your order is completed
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="modal-footer">
                                <a href="{{route('homepage')}}"> <button type="button" class="btn btn-primary">Keep Shopping</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        </div>
    </div>


</div>


@endsection
