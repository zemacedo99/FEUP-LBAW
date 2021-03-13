<?php
include_once '../common/extras.php';
include_once 'supplier_inc_bundle.php';
pageHeader("MyGarden - Create/Edit Bundle");
navbar();
?>

<div class="container">

  <div class="row my-4 border-bottom">
    <h2> Create Bundle<h2>
  </div>

  <div class="row mb-5">

    <?php
    for ($i = 0; $i < 5; $i++) {
      echo '<div class=" col-10 col-sm-6 col-md-4 col-lg-3">';
      createCard();
      echo '</div>';
    }
    ?>
    <div class=" col-10 col-sm-6 col-md-4 col-lg-3">
      <label for="file-input">
        <img src="../images/genericAddImage.png" alt="Add Image" class="img-fluid" style="height: 134px">
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
  <div class="row mt-5">
    <label for="Description">Description</label>
  </div>
  <div class="row justify-content-center">
    <div class="col-12 col-md-4 col-lg-6">
      <div class="form">
        <textarea class="form-control" id="Description" rows="5"></textarea>
      </div>
    </div>

    <div class="col-6 col-lg-6 mt-4 mt-md-0" style="min-height: 100px;">
      <div class="d-grid gap-2 d-lg-block  ">

        <button class="btn btn-primary btn-sm">Add+</button>

        <button class="btn btn-secondary btn-sm">Organic X</button>

        <button class="btn btn-secondary btn-sm">Food X</button>

        <button class="btn btn-secondary btn-sm">Fresh X</button>

        <button class="btn btn-secondary btn-sm">Vegetable X</button>
      </div>

    </div>
  </div>


  <div class="row my-5">
    <span class="text-center">
      <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Bundle</button>
      <button type="button" class="btn btn-primary">Confirmar</button>
    </span>
  </div>
</div>

<?php
footer();
?>