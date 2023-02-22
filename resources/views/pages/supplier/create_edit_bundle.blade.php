@extends('layouts.app')

@section('content')


    @include('partials.modals.supplier_products', $products)

    <script type="text/javascript" src={{ asset('js/create_bundle.js') }} defer> </script>




    <div class="container">

        <div class="col order-1">
            <div class="row">

                <div class="row my-4 border-bottom">
                    <div class="col-10">

                        <h2>{{ $title }}<h2>

                    </div>
                    <div class="col-2">
                        <a href="{{ route('supplier_bundles_and_coupons'  , ['id' => \Illuminate\Support\Facades\Auth::id()]) }}" class="link-dark" style='text-align:right;'>Back to bundles&coupons</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-5"></div>
            <div class="col-2"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSupplierProducts">Add Products</button></div>
            <div class="col-5"></div>

        </div>

        <div class="row mb-5">
            <div class=" col-10 col-sm-6 col-md-4 col-lg-3" id="divCardProds"></div>
 
        </div>

        <form action="{{ $path }}" method="POST" id="form" enctype="multipart/form-data" required>
            @isset($name)
                @method('PUT')
                <div style="display: none" id="edit"></div>
            @endisset
            @csrf
            <div class="row my-3  justify-content-center">
                <div class="col-10 col-lg-3">
                    <label for="bundle_name">Bundle Title</label>
                    <input type="text" class="form-control" id="bundle_name" name="bundle_name" @isset($name)
                    value="{{ $name }}" @endisset>
                    <small id="bundle_name_alert" class="text-danger"></small>
                </div>


                <input type="hidden" name="supplierID" id="supplierID"
                    value="{{ \Illuminate\Support\Facades\Auth::id() }}">


                <div class="col-5 col-lg-2">
                    <label for="price">Price</label>
                    <div class="input-group">
                        <span class="input-group-text">€</span>
                        <input type="number" step="0.01" class="form-control" min=0 id="bundle_price" name="bundle_price"
                            @isset($price) value="{{ $price }}" @endisset>
                        <div class="row" style="margin-left: 0.1em">
                            <small id="bundle_price_alert" class="text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="col-5 col-lg-2">
                    <label for="bundle_stock">Stock</label>
                    <input type="number" class="form-control" id="bundle_stock" name="bundle_stock" min="0"
                            @isset($stock) value="{{ $stock }}" @endisset>
                    <small id="bundle_stock_alert" class="text-danger"></small>
                </div>
            </div>


            <!-- Description + Tags -->
            @include('partials.description_and_tags')


            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            @if (session()->has('message'))
                <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
                    <!-- Position it -->
                    <div style="position: absolute; top: 0; right: 0;">
                        <!-- Then put toasts within -->
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-body">
                                {{ session('message') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

    </div>

    <div class="row my-5">
        <span class="text-center">
            <input type="submit" class="btn btn-primary" value="Confirmar" > 
            @isset($name)
                <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Bundle</button>
            @endisset
        </span>
    </div>


    </form>

@endsection
