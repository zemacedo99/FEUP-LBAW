<?php
include_once '../common/extras.php';
pageHeader("MyGarden - Create/Edit Bundle");
navbar();
?>

<div class="container">

  <div class="pt-4 my-md-5 pt-md-5 border-bottom">
    <h2><b> Create Bundle</b>
      <h2>
  </div>


  <div id="ProductCardsContainer" class="container bg-secondary">

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
      <div class="col">
        <div class="card shadow-sm">
          <img class="col-sm-6" src="https://saude.abril.com.br/wp-content/uploads/2016/11/mac3a7c3a3.jpg" alt="Maça" />
          <div class="card-body"></div>
          <div class="col-sm-6">
            <h5 class="card-title">Maça</h5>
            <div class="card-text">
              <ul class="list-inline">
                <li class="list-inline-item">Total:</li>
                <li class="list-inline-item" id="quantity">5</li>
            </div>

          </div>
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus-circle"></i></button>
              <button type="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-dash-circle"></i></button>
            </div>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card shadow-sm">
          <img class="col-sm-6" src="https://saude.abril.com.br/wp-content/uploads/2016/11/mac3a7c3a3.jpg" alt="Maça" />
          <div class="card-body"></div>
          <div class="col-sm-6">
            <h5 class="card-title">Maça</h5>
            <div class="card-text">
              <ul class="list-inline">
                <li class="list-inline-item">Total:</li>
                <li class="list-inline-item" id="quantity">5</li>
            </div>

          </div>
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus-circle"></i></button>
              <button type="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-dash-circle"></i></button>
            </div>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card shadow-sm">
          <img class="col-sm-6" src="https://saude.abril.com.br/wp-content/uploads/2016/11/mac3a7c3a3.jpg" alt="Maça" />
          <div class="card-body"></div>
          <div class="col-sm-6">
            <h5 class="card-title">Maça</h5>
            <div class="card-text">
              <ul class="list-inline">
                <li class="list-inline-item">Total:</li>
                <li class="list-inline-item" id="quantity">5</li>
            </div>

          </div>
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus-circle"></i></button>
              <button type="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-dash-circle"></i></button>
            </div>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card shadow-sm">
          <img class="col-sm-6" src="https://saude.abril.com.br/wp-content/uploads/2016/11/mac3a7c3a3.jpg" alt="Maça" />
          <div class="card-body"></div>
          <div class="col-sm-6">
            <h5 class="card-title">Maça</h5>
            <div class="card-text">
              <ul class="list-inline">
                <li class="list-inline-item">Total:</li>
                <li class="list-inline-item" id="quantity">5</li>
            </div>

          </div>
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus-circle"></i></button>
              <button type="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-dash-circle"></i></button>
            </div>
          </div>
        </div>
      </div>
      <div class="col"></div>
      <div class="col"></div>
      <div class="col"></div>
      <div class="row align-items-end">
        <div id="Add product button" class="text-center ">
          <button type="button" class="btn btn-light"><b>Add product +</b></button>
        </div>
      </div>
    </div>

  </div>





  <div id="DataContainer" class="container mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-3">
        <input type="text" id="bundleName" placeholder="bundle title">
      </div>
      <div class="col-3">
        <input type="number" id="price" placeholder="price">€
      </div>

      <div class="col-2">
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

<?php
footer();
?>