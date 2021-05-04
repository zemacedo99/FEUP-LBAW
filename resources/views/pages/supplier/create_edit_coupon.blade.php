@extends('layouts.app')

@section('content')

{{-- <script type="text/javascript" src={{ asset('js/create_coupon.js') }} defer> </script> --}}

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

    <div class="container">

        <div class="pt-4 my-md-5 pt-md-5 border-bottom">
            <h2><b> Create Coupon</b></h2>
        </div>
        <form action="/api/coupon" method="POST" id="form" required>
            <input type="hidden" id="supplierID" value="{{ \Illuminate\Support\Facades\Auth::id() }}">
            <div class="row">

                <div class="col-12 col-lg-3 align-items-center">

                    <label class="text-black" for="coupon_name" >Coupon Name</label>

                    
                    <div class="input-group">
                        <input type="text" class="form-control" id=coupon_name class="@error('coupon_name') is-invalid @enderror">
                        
                    </div>
                    
                    @error('coupon_name')
                        <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                    @enderror

                    <label class="text-black" for="coupon_amount">Discount</label>
                    <div class="input-group mb-5">
                        <input type="number" step="0.01" class="form-control" min=0 id="coupon_amount">
                        <select class="form-select" aria-label="Select type" id="coupon_type">
                            <option selected>%</option>
                            <option value="2">€</option>
                        </select>
                    </div>

                    <br>

                </div>


                <div class="row">
                    <div id="DescriptionContainer" class="col-sm-6">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" rows="5"></textarea>
                        </div>
                    </div>
                    <div id="OtherInformationContainer" class="col-sm-6">
                        <div class="form-group row">
                            <b>
                                <label for="date" class="col-2 col-form-label">Date</label>
                            </b>
                            <div class="col-10">
                                <input class="form-control" type="date" value="2011-08-19" id="date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <b>
                                <label for="code" class="col-2 col-form-label">Code</label>
                            </b>
                            <div class="col-10">
                                <input class="form-control" type="text" placeholder="code" id="code">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row my-5">
                <span class="text-center">
                    <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Coupon</button>
                    <input type="submit" class="btn btn-primary" value="Confirmar">
                </span>
            </div>
        </form>
    </div>

@endsection
