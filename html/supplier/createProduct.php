<?php
include_once '../common/extras.php';
pageHeader("MyGarden - Create Product");
navbar();
?>

<div class="container">

  <div class="pt-4 my-md-5 pt-md-5 border-bottom">
    <h2><b> Create Product</b></h2>
  </div>

  <div class="row">
    <div id="mainContainer" class="col-sm-8">


      <div id="carrouselContainer" class="container">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner" style=" width:100%; height: 500px !important;">
            <div class="carousel-item active">
              <img src="https://www.infoescola.com/wp-content/uploads/2010/11/ma%C3%A7a-verde_312027470.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="../images/apples.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="https://www.portaldojardim.com/pdj/wp-content/uploads/Ma%C3%A7as-verdes.jpg" class="d-block w-100" alt="...">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>
    <div id="DataContainer" class="col-md-4 mt-5">
      <h4><b><input type="text" placeholder="Product Name" value="Green apples"></b></h4>
      <div class="row mt-5">
        <div class="col">

          <h5 class="text"><b>€<input type="number" id="price" placeholder="price"></b></h5>
        </div>
        <div class="col-4">
          <div class="col-auto my-1">

            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
              <option selected>unit</option>
              <option value="€">Kg</option>
            </select>
          </div>

        </div>
        <div class="col mt-5">
          <input type="number" placeholder="stock">
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
      <div id="TagsContainer" class="col-sm-6">
        <div class="form-group">
          <label for="tags">Tags</label>
          <div class="container" id="tags" style="border: 1px solid">
            <span class="badge bg-secondary">Organic</span>
            <span class="badge bg-secondary">Food</span>
            <span class="badge bg-secondary">Fresh</span>
            <span class="badge bg-secondary">Vegetable</span>
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