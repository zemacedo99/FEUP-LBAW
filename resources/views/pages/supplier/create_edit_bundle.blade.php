@extends('layouts.app')

@section('content')

    <script type="text/javascript" src={{ asset('js/create_bundle.js') }} defer> </script>

    <div class="container">

        <div class="row my-4 border-bottom">
            <h2>{{ $title }}<h2>
        </div>

        <div class="row mb-5">


            <div class=" col-10 col-sm-6 col-md-4 col-lg-3">
                @include('partials.cards.product_in_bundle')
            </div>


            {{-- <div class=" col-10 col-sm-6 col-md-4 col-lg-3">
                <label for="file-input">
                    <img src="../images/genericAddImage.png" alt="Add Product" class="img-fluid" style="height: 134px">
                </label>
                <input id="file-input" type="file" class="invisible">
            </div> --}}
        </div>

        <form action="{{ $path }}" method="POST" id="form" enctype="multipart/form-data" required>
          @csrf
            <div class="row my-3  justify-content-center">
                <div class="col-10 col-lg-3">
                    <label for="bundle_name">Bundle Title</label>
                    <input type="text" class="form-control" id="bundle_name" name="bundle_name">
                    <small id="bundle_name_alert" class="text-danger"></small>
                </div>
                <div class="col-5 col-lg-2">
                    <label for="price">Price</label>
                    <div class="input-group">
                        <span class="input-group-text">€</span>
                        <input type="text" class="form-control" id="bundle_price" name="bundle_price">
                        <div class="row" style="margin-left: 0.1em">
                            <small id="bundle_price_alert" class="text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="col-5 col-lg-2">
                    <label for="bundle_stock">Stock</label>
                    <input type="number" class="form-control" id="bundle_stock" name="bundle_stock" min="1">
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
            <input type="submit" class="btn btn-primary" value="Confirmar">
            {{-- <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Bundle</button> --}}
        </span>
    </div>
  </form>

@endsection
