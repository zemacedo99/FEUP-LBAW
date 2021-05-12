@extends('layouts.app')

@section('content')


    <script type="text/javascript" src={{ asset('js/create_product.js') }} defer> </script>

    <div class="container">

        <div class="row my-5 border-bottom">
            <h2 class="text-start"> {{ $title }}</h2>
        </div>


        <div class="row mb-4">

            @include('partials.carousel_img')

            <div class="col-1"></div>

            <div class="col-12 col-lg-3">
                <form action="{{ $path }}" method="POST" id="form" required>
                    @csrf
                    <label class="text-black" for="product_name">Product Name</label>

                    <div class="row" style="margin-left: 0.1em">
                        <input type="text" class="form-control" id=product_name name=product_name @isset($name) value="{{ $name }}"
                            @endisset>

                        <small id="product_name_alert" class="text-danger"></small>
                    </div>

                    <div class="row   mb-5"></div>

                    <input type="hidden" name="supplierID" id="supplierID"
                        value="{{ \Illuminate\Support\Facades\Auth::id() }}">

                    <label class="text-black" for="product_price">Price</label>

                    <div class="input-group">
                        <span class="input-group-text">€</span>
                        <input type="number" step="0.01" class="form-control" min=0 id="product_price" name="product_price"@isset($price)
                        value="{{ $price }}" @endisset>
                        <select class="form-select"  name="product_type" aria-label="Select type" id="product_type" >
                            <option @isset($kg) selected @endisset>Kg</option>
                            <option @isset($unit) selected @endisset value='Un'>Unit</option>
                        </select>
                    </div>
                    <div class="row" style="margin-left: 0.1em">
                    <small id="product_price_alert" class="text-danger"></small>
                    </div>
                    <div class="row   mb-5"></div>

                    <label class="text-black" for="product_stock">Stock</label>
                    <div class="row" style="margin-left: 0.1em">
                        <input type="number" class="form-control" id="product_stock" name="product_stock"  min="0" @isset($stock)
                            value="{{ $stock }}" @endisset>

                        <small id="product_stock_alert" class="text-danger"></small>
                    </div>


                    <div class="input-group my-5 justify-content-center">

                        {{-- <form action= "upload" method="POST" enctype="multipart/form-data" >
                            <label class="btn btn-primary" for="sup_img" name="file">
                                Add Image
                            </label>
                        </form> --}}

                        <form action= "upload" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type= "file" name = "file"> <br> <br>
                            <button type = "submit" class="btn btn-primary"> Add Image </button>
                            
                        </form>

                        <input type="file" class="form-control d-none" id="sup_img" name="sup_img"  aria-describedby="sup_img_addon"
                            aria-label="Upload">
                        <button class="btn btn-danger" type="button" id="sup_img_addon">Clear All</button>
                    </div>



            </div>
            <div class="col"></div>
        </div>

        @include('partials.description_and_tags')

        <div class="row my-5">
            <span class="text-center">
                <input type="submit" class="btn btn-primary" value="Confirmar">
                <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Product</button>
            </span>
        </div>

    </div>
    </form>

@endsection
