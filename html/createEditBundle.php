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
      <p> Create Bundle</p>
    </div>


    <div id="ProductCardsContainer" class="container bg-secondary">
      <!-- <div class="card" style="width: 18rem;">
          <div class="row card-body">
            <img class="col-sm-6" src="https://saude.abril.com.br/wp-content/uploads/2016/11/mac3a7c3a3.jpg" alt="Maça" />
            <div class="col-sm-6">
              <h5 class="card-title">Maça</h5>
              <div class="card-text">
                <ul class="list-inline">
                  <li class="list-inline-item">Total:</li>
                  <li class="list-inline-item" id="quantity">5</li>
              </div>
      
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle"
                viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path
                  d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle"
                viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
              </svg>
            </div>
      
          </div>
      
        </div> -->

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
      </div>

    </div>

  </div>



  <div id="DataContainer" class="container">
    <ul class="list-inline">
      <li class="list-inline-item">Bundle Name</li>
      <li class="list-inline-item">price</li>
      <li class="list-inline-item">€</li>
      <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
        <option selected>Choose...</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
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
        <textarea class="form-control" id="tags" rows="5" disabled>
          <h1>Example heading <span class="badge badge-secondary">New</span></h1>
        </textarea>
      </div>
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