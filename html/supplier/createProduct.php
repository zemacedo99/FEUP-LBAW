<?php
include_once '../common/extras.php';
pageHeader("MyGarden - Create Product");
navbar();
?>

<div class="container">

  <div class="row my-5 border-bottom">
    <h2 class="text-start"> Create Product</h2>
  </div>


  <div class="row mb-4">

    <!-- Carrousel -->
    <div id="mainContainer" class="col-12 col-lg-6 mb-5 mb-lg-0">
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner" style=" width:100%; max-height: 400px !important;">
          <div class="carousel-item active">
            <img src="https://www.infoescola.com/wp-content/uploads/2010/11/ma%C3%A7a-verde_312027470.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../images/green_apple2.jpg" class="d-block w-100" alt="...">
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

    <div class="col-1"></div>

    <div class="col-12 col-lg-3">
      <form action="">
        <label class="text-black" for="product_name">Product Name</label>
        <div class="input-group mb-5 ">
          <input type="text" class="form-control" id=product_name>
    
        </div>

        <label class="text-black" for="product_price">Price</label>
        <div class="input-group mb-5">
          <span class="input-group-text">€</span>
          <input type="text" class="form-control" id="product_price">
          <select class="form-select" aria-label="Select type">
            <option selected>Kg</option>
            <option value="2">Unit</option>
          </select>
        </div>

        <label class="text-black" for="product_stock">Stock</label>
        <div class="input-group mb-5">
          <input type="number" class="form-control" id="product_stock" min="1">
        </div>
        
        <div class="input-group my-5 justify-content-center">
          <label class="btn btn-primary" for="sup_img">
            Add Image
          </label>
          <input type="file" class="form-control d-none" id="sup_img" aria-describedby="sup_img_addon" aria-label="Upload">
          <button class="btn btn-danger" type="button" id="sup_img_addon">Clear All</button>
        </div>
      
      </form>
    </div>
    <div class="col"></div>
  </div>


  <!-- Description + Tags -->
  <div class="row">
    <label for="Description">Description</label>
  </div>
  <div class="row">
    <div class="col-12 col-md-4 col-lg-6">
      <div class="form">
        <textarea class="form-control" id="Description" rows="5"></textarea>
      </div>
    </div>

    <div class="col-12 col-lg-6" style="min-height: 100px;">
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
      <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Product</button>
      <button type="button" class="btn btn-primary">Confirmar</button>
    </span>
  </div>


</div>

<?php
footer();
?>