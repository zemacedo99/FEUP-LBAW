@extends('layouts.app')

@section('content')


<div class="container">

    <div class="row my-4 border-bottom">
      <h2> Create Bundle<h2>
    </div>
  
    <div class="row mb-5">
  
        <?php for ($i = 0; $i < 5; $i++) {  ?>
            <div class=" col-10 col-sm-6 col-md-4 col-lg-3">
                @include('partials.cards.product_in_bundle')
            </div>
        <?php } ?>

      <div class=" col-10 col-sm-6 col-md-4 col-lg-3">
        <label for="file-input">
          <img src="../images/genericAddImage.png" alt="Add Product" class="img-fluid" style="height: 134px">
        </label>
        <input id="file-input" type="file" class="invisible">
      </div>
    </div>
  
    <form action="">
      <div class="row my-3  justify-content-center">
        <div class="col-10 col-lg-3">
          <label for="bundleName">Bundle Title</label>
          <input type="text" class="form-control" id="bundleName">
        </div>
        <div class="col-5 col-lg-2">
          <label for="price">Price</label>
          <div class="input-group">
            <span class="input-group-text">€</span>
  
            <input type="text" class="form-control" id="price">
          </div>
        </div>
  
        <div class="col-5 col-lg-2">
          <label for="bundleStock">Stock</label>
          <input type="number" class="form-control" id="bundleStock" min="1">
        </div>
      </div>
    </form>
  
  
    <!-- Description + Tags -->
    @include('partials.description_and_tags')
    
  </div>
  
  <div class="row my-5">
      <span class="text-center">
        <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Bundle</button>
        <button type="button" class="btn btn-primary">Confirmar</button>
      </span>
    </div>

@endsection