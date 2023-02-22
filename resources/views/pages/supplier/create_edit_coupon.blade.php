@extends('layouts.app')

@section('content')

<script type="text/javascript" src={{ asset('js/create_coupon.js') }} defer> </script>

    <div class="container">

        <div class="pt-4 my-md-5 pt-md-5 border-bottom">
            <h2><b> {{ $title }}</b></h2>
        </div>
        <form action="{{$path}}" method="POST" id="form" required>
            @isset($name)
                @method('PUT')
                <div style="display: none" id="edit"></div>
            @endisset 
            
            
            <input type="hidden" name="supplierID" id="supplierID" value="{{ \Illuminate\Support\Facades\Auth::id() }}">
            <div class="row">

                <div class="col-12 col-lg-3 align-items-center">

                    

                    <label class="text-black" for="coupon_name" >Coupon Name</label>
                    <div class="row" style="margin-left: 0.1em">
                        
                        <input type="text" class="form-control" name="coupon_name" id="coupon_name" @isset($name) value="{{$name}}" @endisset>
                        <small id="coupon_name_alert" class="text-danger">
                           
                        </small>
                    </div>

                    <div class="row mb-5"></div>

                    <label class="text-black" for="coupon_amount">Discount</label>
                    <div class="input-group">
                        <input type="number" name="coupon_amount" step="0.01" class="form-control" min=0 id="coupon_amount" @isset($amount) value="{{$amount}}" @endisset>
                        <select class="form-select" name="coupon_type" aria-label="Select type" id="coupon_type" >
                            <option @isset($p) selected @endisset value="%" >%</option>
                            <option @isset($e) selected @endisset value="€">€</option>
                        </select>
                    </div>
                    <small id="coupon_amount_alert" class="text-danger"></small>

                    <br>

                </div>

                <div class="row mt-5">
                    <div id="DescriptionContainer" class="col-sm-6">
                        <div class="form-group mb-1">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="5">@isset($description) {{$description}} @endisset</textarea>
                        </div>
                        <small id="description_alert" class="text-danger"></small>
                    </div>
                    <div id="OtherInformationContainer" class="col-sm-6">
                        <div class="form-group row">
                            <b>
                                <label for="date" class="col-form-label">Expiration Date</label>
                            </b>
                            <div class="col-10">
                                <input class="form-control" type="date" name="date" id="date"  @isset($expiration) value="{{$expiration}}" @endisset>
                            </div>
                            <small id="date_alert" class="text-danger"></small>
                        </div>
                        <div class="form-group row">
                            <b>
                                <label for="code" class="col-2 col-form-label">Code</label>
                            </b>
                            <div class="col-10">
                                <input class="form-control" name="code" type="text" placeholder="code" id="code"  @isset($code) value="{{$code}}" @endisset>
                                <small id="code_alert" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row my-5">
                <span class="text-center">
                    <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Coupon</button>
                    <input type="submit" class="btn btn-primary" value="Confirm">
                </span>
            </div>
        </form>
    </div>

@endsection
