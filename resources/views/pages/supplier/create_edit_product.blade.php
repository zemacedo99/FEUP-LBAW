@extends('layouts.app')

@section('content')


    <script type="text/javascript" src={{ asset('js/create_product.js') }} defer> </script>

    <div class="container">

        

        <div class="col order-1">
            <div class="row" style='border-bottom:2px solid black;'>
                <div class="row mb-3"></div>
                <div class="col-10">
                    <h2 class="text-start"> {{ $title }}</h2>
                </div>
                <div class="col-2">
                    <a href="{{ route('supplier_all_products', ['id' => \Illuminate\Support\Facades\Auth::id()]) }}"
                        class="link-dark" style='text-align:right;'>See all Products</a>
                </div>
            </div>
        </div>

        <div class="row mb-5"></div>
        <div class="row mb-4">

            {{-- @include('partials.carousel_img') --}}

            <div class="col-4"></div>


            <div class="col-12 col-lg-4 justify-content-center">
                <form action="{{ $path }}" method="POST" id="form" enctype="multipart/form-data" required>
                    @csrf
                    <label class="text-black" for="product_name">Product Name</label>

                    <div class="row" style="margin-left: 0.1em">
                        <input type="text" class="form-control" id=product_name name=product_name @isset($name)
                            value="{{ $name }}" @endisset>

                        <small id="product_name_alert" class="text-danger"></small>
                    </div>

                    <div class="row mb-3"></div>

                    <input type="hidden" name="supplierID" id="supplierID"
                        value="{{ \Illuminate\Support\Facades\Auth::id() }}">

                    <label class="text-black" for="product_price">Price</label>

                    <div class="input-group">
                        <span class="input-group-text">€</span>
                        <input type="number" step="0.01" class="form-control" min=0 id="product_price" name="product_price"
                            @isset($price) value="{{ $price }}" @endisset>
                        <select class="form-select" name="product_type" aria-label="Select type" id="product_type">
                            <option @isset($kg) selected @endisset>Kg</option>
                            <option @isset($unit) selected @endisset value='Un'>Unit</option>
                        </select>
                    </div>
                    <div class="row" style="margin-left: 0.1em">
                        <small id="product_price_alert" class="text-danger"></small>
                    </div>
                    <div class="row mb-3"></div>

                    <label class="text-black" for="product_stock">Stock</label>
                    <div class="row" style="margin-left: 0.1em">
                        <input type="number" class="form-control" id="product_stock" name="product_stock" min="0"
                            @isset($stock) value="{{ $stock }}" @endisset>

                        <small id="product_stock_alert" class="text-danger"></small>
                    </div>



                    {{-- <div class="input-group my-5 justify-content-center">
                        <label class="btn btn-primary" for="sup_img" name="file">
                            Add Image
                        </label>
                        <label for="Image Name" class="btn btn-primary">Add Image (can attach more than one):</label>
                        <input type="file" class="form-control d-none" id="sup_img" name="sup_img"
                            aria-describedby="sup_img_addon" aria-label="Upload">
                        <button class="btn btn-danger" type="button" id="sup_img_addon">Clear All</button>
                    </div> --}}



                    <div class="row justify-content-center">
                        <div class="row mb-3 "></div>
                        <div class="col-12 col-lg-12 d-flex justify-content-center mb-4">
                            <label class="btn btn-primary" for="sup_img">
                                Add pictures
                            </label>
                            {{-- para ter feedback tirar class="form-control d-none" --}}
                            <input type="file" class="form-control d-none" id="sup_img" name="images[]"
                                aria-describedby="sup_img_addon" aria-label="Upload" multiple
                                accept="image/x-png,image/gif,image/jpeg">
                        </div>


                        {{-- <div class="row mb-1 "></div>
                        <input type="file" class="btn btn-primary" name="images[]" multiple />
                        <div class="row mb-1 "></div>
                        <input type="file" class="btn btn-primary" name="images[]" multiple /> --}}
                    </div>

                    @include('partials.description_and_tags')

            </div>



            {{-- <div class="col"></div> --}}
        </div>



        <div class="row my-5">
            <span class="text-center">
                <input type="submit" class="btn btn-primary" value="Confirmar">
                {{-- <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Product</button> --}}
            </span>
        </div>


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

                {{-- <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
                    <div class="toast-header">
                        <img src="..." class="rounded mr-2" alt="...">
                        <strong class="mr-auto">Bootstrap</strong>
                        <small class="text-muted">2 seconds ago</small>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        Heads up, toasts will stack automatically
                    </div>
                </div> --}}
            </div>
        </div>
        @endif
       

        {{-- @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class= "fa fa-check-circle mr-1"></i> {{ session('message') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif --}}
   

        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
    </div>
    </form>

@endsection
