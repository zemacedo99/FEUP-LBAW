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
                        <li class="breadcrumb-item"><a href="{{route('checkout', ['id' => $user_id ])}}" style="text-decoration: none; color: black;">Information</a></li>
                        <li class="breadcrumb-item active" id="selectedLink" aria-current="page">Shipping / Payment</li>
                    </ol>
                </nav>
            </div>
            <div class="row m-3"></div>

            <form action="/api/payment" method="POST" id="form">
            <div class="row">

                <!-- <div class="col"></div> -->

                <!-- ****************** Left Side ****************** -->
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h3 style='text-align:left;border-bottom:2px solid black;'>Shipping Address</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>


                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="FirstName" value=@isset($sd) {{$sd->first_name}} @endisset>
                                <label for="first_name">First Name</label>
                            </div>
                            <small id="first_name_alert" class="text-danger"></small>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="LastName" value=@isset($sd) {{$sd->last_name}} @endisset>
                                <label for="last_name">Last Name</label>
                            </div>
                            <small id="last_name_alert" class="text-danger"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value=@isset($sd) {{$sd->address}} @endisset>
                                <label for="address">Address</label>
                            </div>
                            <small id="address_alert" class="text-danger"></small>
                        </div>
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="door_n" name="door_n" placeholder="Door N" value=@isset($sd) {{$sd->door_n}} @endisset>
                                <label for="door">Door Nº</label>
                            </div>
                            <small id="door_n_alert" class="text-danger"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="post_code" name="post_code" placeholder="Zip Code" value=@isset($sd) {{$sd->post_code}} @endisset>
                                <label for="zip_code">Zip Code</label>
                            </div>
                            <small id="post_code_alert" class="text-danger"></small>
                        </div>
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="district" name="district" placeholder="District" value=@isset($sd) {{$sd->district}} @endisset>
                                <label for="district">District</label>
                            </div>
                            <small id="district_alert" class="text-danger"></small>
                        </div>
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="city" name="city" placeholder="City" value=@isset($sd) {{$sd->city}} @endisset>
                                <label for="city">City</label>
                            </div>
                            <small id="city_alert" class="text-danger"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="country" name="country" placeholder="Country" value=@isset($sd) {{$sd->country}} @endisset>
                                <label for="country">Country</label>
                            </div>
                            <small id="country_alert" class="text-danger"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="phone_n" name="phone_n" placeholder="Phone Number" value=@isset($sd) {{$sd->phone_n}} @endisset>
                                <label for="phone">Phone Number</label>
                            </div>
                            <small id="phone_n_alert" class="text-danger"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                <div class="form-check form-switch">
                                    <label class="form-check-label" for="save_ship_info">Save data for future purchases</label>
                                    <input class="form-check-input" type="checkbox" id="save_ship_info" name="save_ship_info">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="col-lg-1"></div>

                <!-- ****************** Right Side ****************** -->
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">

                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h3 style='text-align:left;border-bottom:2px solid black;'>Payment Method</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="radio" class="btn-check " name="PayPal" id="PayPal" autocomplete="off" checked>
                                <label class="btn btn-primary d-flex justify-content-center align-items-center mb-1" id="simple-btt" for="PayPalOption" style="height: 60px;">PayPal</label>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="radio" class="btn-check " name="CreditCard" id="CreditCard" autocomplete="off" checked>
                                <label class="btn btn-primary d-flex justify-content-center align-items-center mb-1" id="simple-btt" for="CreditOption" style="height: 60px;">Credit</label>
                            </div>

                        </div>
                    </div>

                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>

                    <div class="col-12">
                        <h3 class="mb-3 " style='text-align:left;border-bottom:2px solid black;'>Payment Information</h3>

                        @include('partials.cards.credit_card', ['ccs' => $ccs])

                        @include('partials.modals.edit_credit_card')


                        <div class="card mb-3 d-flex justify-content-center align-items-center" style="height: 60px;">
                            <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#addCard"></a>
                            <p class="card-text">Add new Card <i class="bi bi-plus"></i></p>
                        </div>
                    
                        @include('partials.modals.add_credit_card')

                    </div>

                </div>
            </div>

            <div class="row m-3"></div>
            
            <div class="col-12">

                <h4 style='text-align:center;'>Total: 8.37 €</h4>
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
                                <a href="../misc/home_page.php"> <button type="button" class="btn btn-primary">Keep Shopping</button></a>
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
