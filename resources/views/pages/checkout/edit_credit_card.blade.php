@extends('layouts.app')

@section('content')

@include('partials.credit_card_info')


<div class="row mt-3"></div>
<div class="row mt-3"></div>
<div class="row mt-3"></div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-secondary btn-sm"><i class="bi bi-trash"></i> Delete Account</button>
        </div>
    </div>
</div>

<div class="row mt-3"></div>
<div class="row mt-3"></div>
<div class="row mt-3"></div>
<div class="row mt-3"></div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-primary"> <a id="navLinks" href="shipping_payment.php">Confirm</a></button>
        </div>
    </div>
</div>

@endsection
