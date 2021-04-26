@extends('layouts.app')

@section('content')


<div class="container">

    <div class="row mt-3"></div>
    <div class="row mt-3"></div>

    <div class="row ">
        <div class="col-12 col-lg-5">

            <div class="row d-flex justify-content-center mb-3">
                <div class="col-12 col-lg-6" style="width: 15rem;">
                    <img src="../images/img_avatar.png" class="rounded-circle img-fluid">
                </div>
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center justify-content-lg-start">
                    <p class="col-md-auto text-decoration-underline text-center">
                    <h3>Quinta do Bill</h3>
                    </p>
                </div>
            </div>

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

        <?php for ($i = 0; $i < 10; $i++) { ?>

             @include('partials.cards.product_detail_supplier')
             
        <?php } ?>

    </div>

</div>

@endsection