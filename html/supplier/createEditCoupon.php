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
    <div id="imagesContainer" class="col-sm-6">
      <div class="image-upload">
        <label for="file-input">
          <img src="../images/genericAddImage.png" class="img-fluid" />
        </label>
        <input id="file-input" type="file" class="invisible" />
      </div>

    </div>
    <div id="DataContainer" class="col-md-4 mt-5">
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
    </div>


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



    <div class="row">

      <div id="confirmContainer" class="text-center">
        <button type="button" class="btn btn-light">Confirmar</button>
      </div>
      <div id="deleteProductContainer" class="float-end">
        <div class="col-12 d-flex justify-content-center mb-4">
          <button type="button" class="btn btn-secondary btn-sm"><i class="bi bi-trash"></i> Delete Account</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
footer();
?>