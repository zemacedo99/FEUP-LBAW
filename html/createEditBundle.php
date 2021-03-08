<!DOCTYPE html>
<html>

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
      <h2><b> Create Bundle</b><h2>
    </div>


    <div id="ProductCardsContainer" class="container bg-secondary">
      
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <div class="col">
          <div class="card shadow-sm">
            <img class="col-sm-6" src="https://saude.abril.com.br/wp-content/uploads/2016/11/mac3a7c3a3.jpg"
              alt="Maça" />
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
                <button type="button" class="btn btn-sm btn-outline-secondary"><i
                    class="bi bi-plus-circle"></i></button>
                <button type="button" class="btn btn-sm btn-outline-secondary"><i
                    class="bi bi-dash-circle"></i></button>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card shadow-sm">
            <img class="col-sm-6" src="https://saude.abril.com.br/wp-content/uploads/2016/11/mac3a7c3a3.jpg"
              alt="Maça" />
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
                <button type="button" class="btn btn-sm btn-outline-secondary"><i
                    class="bi bi-plus-circle"></i></button>
                <button type="button" class="btn btn-sm btn-outline-secondary"><i
                    class="bi bi-dash-circle"></i></button>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card shadow-sm">
            <img class="col-sm-6" src="https://saude.abril.com.br/wp-content/uploads/2016/11/mac3a7c3a3.jpg"
              alt="Maça" />
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
                <button type="button" class="btn btn-sm btn-outline-secondary"><i
                    class="bi bi-plus-circle"></i></button>
                <button type="button" class="btn btn-sm btn-outline-secondary"><i
                    class="bi bi-dash-circle"></i></button>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card shadow-sm">
            <img class="col-sm-6" src="https://saude.abril.com.br/wp-content/uploads/2016/11/mac3a7c3a3.jpg"
              alt="Maça" />
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
                <button type="button" class="btn btn-sm btn-outline-secondary"><i
                    class="bi bi-plus-circle"></i></button>
                <button type="button" class="btn btn-sm btn-outline-secondary"><i
                    class="bi bi-dash-circle"></i></button>
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
    <ul class="col text-align:justify">
      <li id="bundleName" class="list-inline-item"><b>Round of apples</b></li>
      <li id="price" class="list-inline-item text-center">50</li>
      <li id="coin" class="list-inline-item">€</li>
      <input type="number" placeholder="stock">
    </ul>
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
    <div id="deleteProductContainer" class="float-end">
      <p>Delete Bundle <i class="bi bi-trash"></i></p>
    </div>

    <div id="confirmContainer" class="text-center">
      <button type="button" class="btn btn-light">Confirmar</button>
    </div>
  </div>
  </div>
  </div>
</body>

</html>