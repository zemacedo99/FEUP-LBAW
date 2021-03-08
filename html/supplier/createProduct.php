<!DOCTYPE html>
<html>

<?php
include '../common/head.php';
include '../common/navbar.php';
?>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

  <title>Title of the document</title>
</head>

<body>
  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
    crossorigin="anonymous"></script>

  <div class="container">

    <div class="pt-4 my-md-5 pt-md-5 border-bottom">
      <h2><b> Create Product</b></h2>
    </div>

    <div class="row">
      <div id="mainContainer" class="col-sm-8">


        <div id="carrouselContainer" class="container">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner" style=" width:100%; height: 500px !important;">
              <div class="carousel-item active">
                <img src="https://www.infoescola.com/wp-content/uploads/2010/11/ma%C3%A7a-verde_312027470.jpg"
                  class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img
                  src="data:image/jpeg;base64,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"
                  class="d-block w-100" alt="...">
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
</body>

</html>