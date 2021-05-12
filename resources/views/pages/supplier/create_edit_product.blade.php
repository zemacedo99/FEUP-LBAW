@extends('layouts.app')

@section('content')


    <script type="text/javascript" src={{ asset('js/create_product.js') }} defer> </script>

    <div class="container">

        <div class="row my-5 border-bottom">
            <h2 class="text-start"> {{ $title }}</h2>
        </div>


        <div class="row mb-4">

            <!-- Carrousel -->
            <div id="mainContainer" class="col-12 col-lg-6 mb-5 mb-lg-0">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner" style=" width:100%; max-height: 400px !important;">
                        <div class="carousel-item active">
                            <img src="https://www.infoescola.com/wp-content/uploads/2010/11/ma%C3%A7a-verde_312027470.jpg"
                                class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="../images/green_apple2.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://www.portaldojardim.com/pdj/wp-content/uploads/Ma%C3%A7as-verdes.jpg"
                                class="d-block w-100" alt="...">
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

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
                            <option @isset($unit) selected @endisset value="2">Unit</option>
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
                        <label class="btn btn-primary" for="sup_img">
                            Add Image
                        </label>

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
