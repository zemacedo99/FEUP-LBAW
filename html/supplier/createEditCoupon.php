<?php
include_once '../common/extras.php';
pageHeader("MyGarden - Create/Edit Coupon");
navbar();
?>

<div class="container">

  <div class="pt-4 my-md-5 pt-md-5 border-bottom">
    <h2><b> Create Coupon</b></h2>
  </div>

  <div class="row">
    <div id="imagesContainer" class="col-12 col-lg-6 mb-5 mb-lg-0">
      <div class="image-upload">
        <label for="file-input">
          <img src="../images/genericAddImage.png" class="img-fluid" />
        </label>
        <input id="file-input" type="file" class="invisible" />
      </div>

    </div>

    <div class="col-12 col-lg-3">
      <form action="">
        <label class="text-black" for="coupon_name">Coupon Name</label>
        <div class="input-group mb-5 ">
          <input type="text" class="form-control" id=coupon_name>

        </div>

        <label class="text-black" for="coupon_price">Discount</label>
        <div class="input-group mb-5">
          <input type="number" step="0.01" class="form-control" min=0 id="coupon_price">
          <select class="form-select" aria-label="Select type">
            <option selected>%</option>
            <option value="2">€</option>
          </select>
        </div>

        <label class="text-black" for="coupon_stock">Stock</label>
        <div class="input-group mb-5">
          <input type="number" class="form-control" id="coupon_stock" min="1">
        </div>

        <div class="input-group my-5 justify-content-center">
          <label class="btn btn-primary" for="sup_img">
            Add Image
          </label>
          <input type="file" class="form-control d-none" id="sup_img" aria-describedby="sup_img_addon"
            aria-label="Upload">
          <button class="btn btn-danger" type="button" id="sup_img_addon">Clear All</button>
        </div>

      </form>
    </div>
    <!-- <div id="DataContainer" class="col-md-4 mt-5">
      <h4><b><input type="text" placeholder="Coupon Name"></b></h4>
      <div class="row mt-5">
        <div class="col">
          <i class="text-muted">discount</i>
          <h6 class="text-muted"><input type="text" placeholder="Amount"></h6>
        </div>
        <div class="col">
          <div class="col-auto my-1">

            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
              <option selected>%</option>
              <option value="€">€</option>
            </select>
          </div>
        </div>
      </div>
    </div> -->


    <div class="row">
      <div id="DescriptionContainer" class="col-sm-6">
        <div class="form-group">
          <label for="Description">Description</label>
          <textarea class="form-control" id="Description" rows="5"></textarea>
        </div>
      </div>
      <div id="OtherInformationContainer" class="col-sm-6">
        <div class="form-group row">
          <b>
            <label for="Coupon expire date" class="col-2 col-form-label">Date</label>
          </b>
          <div class="col-10">
            <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
          </div>
        </div>
        <div class="form-group row">
          <b>
            <label for="Coupon Code" class="col-2 col-form-label">Code</label>
          </b>
          <div class="col-10">
            <input class="form-control" type="text" placeholder="code" id="example-search-input">
          </div>
        </div>
      </div>
    </div>
  </div>


    <div class="row my-5">
      <span class="text-center">
        <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Coupon</button>
        <button type="button" class="btn btn-primary">Confirmar</button>
      </span>
    </div>
  
</div>

<?php
footer();
?>