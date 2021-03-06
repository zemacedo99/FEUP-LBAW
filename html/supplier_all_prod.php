<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <!-- material icons-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!--  css links -->
  <link href="sytle.css" rel="stylesheet">

  <title>MyGarden</title>
</head>


<body>
  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

  <header>

    <!-- navbar global -->
    <nav class="navbar navbar-expand-md navbar-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php"> <img alt="Logo" src="logo.png" width="100" height="25"> </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <!-- <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li> -->
            <li class="nav-item">
              <a class="nav-link" id="navLinks" href="#">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="navLinks" href="#">Stores</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="navLinks" href="#">About Us</a>
            </li>

          </ul>

          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button type="button" id="headericon">search</button>
          </form>
        </div>


        <!-- navbar only for mobile -->
        <!-- 
        <div class="expand navbar-expand-lg" id="navbarSupportedContent">

          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"  href="#">Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"  href="#">Stores</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"  href="#">About Us</a>
              </li>
          </ul>

        </div> 
      -->



        <!-- navbar profile and cart buttons -->
        <div class="navbar-nav ms-auto">
          <div class="col align-items-end">
            <button type="button" id="headericon">account_circle</button>
            <button type="button" id="headericon">shopping_cart</button>
          </div>
        </div>
      </div>
    </nav>

    <div class="container">

      <!-- profile info -->
      <div class="container">
        <div class="row justify-content-md-center">
          <div class="d-flex flex-row bd-highlight mb-5">
            <div class="p-2 bd-highlight "> <img src="batata-amarela.jpg" alt="QuintaDoBill" class="rounded-circle"> </div>
            <div class="align-self-md-center">
              <h2>Quinta do Bill<h2>
            </div>
          </div>
        </div>
      </div>

      <h3> All Products </h3>
      <div class="row mt-3"></div>
      <div class="row mt-3"></div>
      <div class="row mt-3"></div>


      <!-- Produtc display ex: -->
      <!-- <div class="card h-100">
          <img src="bananas.jpg" class="img-thumbnail" alt="bananas" width="200" height="200" >
          <div class="card-body">
            <h5 class="card-title">Bananas</h5>
            <p class="card-text">Na Quinta do Bill tens bananas que te fazem voar, voar, voar.</p>
          </div>
      </div> -->

      <!-- Produtc display ex: -->
      <!-- <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
          <div class="col-md-4">
           <img src="bananas.jpg" class="card-img-top" alt="bananas" >
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">Bananas</h5>
              <p class="card-text"><small class="text-muted">7.80€/kg</small></p>
              <p class="card-text">Na Quinta do Bill tens bananas que te fazem voar, voar, voar.</p>
            </div>
          </div>
        </div>
      </div> -->

      <!-- Produtc display ex: -->
      <!-- <div class="card mb-3">
        <div class="row g-0">
          <div class="col-4 col-md-3 col-lg-2 col-xl-2">
            <img src="https://via.placeholder.com/150x150" alt="...">
          </div>
          <div class="col-8 col-md-9 col-lg-10 col-xl-10">
            <div class="card-body">
              <div class="d-flex justify-content-between justify-content-md-start">
                <h4 class="card-title">Maças Vermelhas</h4>
                <i class="bi bi-cart-plus ps-md-4"></i>
              </div>
              <h6 class="card-subtitle text-muted">3,50€/kg</h6>

              <div class="row row-cols-1 row-cols-md-2">
                <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9">
                  Este é outro texto mega interessante sobre maças vermelhas, boas para comer cruas ou assadas, possuem tamanhos variados, mas parece que a descrição não cabe aqui então v..
                </p>
                <h4 class="card-title text-end text-md-start order-md-3">2,50€</h4>
                <div class="text-center order-md-2 col-md-3 col-lg-3">
                  <button type="button" class="btn btn-primary"><i class="bi bi-list"></i> Edit Review</button>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div> -->

      <!-- List of all products that a store have -->
      <div class="row row-cols-1 row-cols-sm-2 g-4">

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

          <div class="card h-100" style="width: 540px; height: 200px; max-width: 540px;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="bananas.jpg" class="card-img-top" alt="bananas">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">Bananas</h5>
                  <p class="card-text"><small class="text-muted">7.80€/kg</small></p>
                  <p class="card-text">Na Quinta do Bill tens bananas que te fazem voar, voar, voar.</p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

          <div class="card h-100" style="width: 540px; height: 200px; max-width: 540px;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="batata_vermelha.jpg" class="card-img-top" alt="batatas vermelhas">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">Batatas vermelhas</h5>
                  <p class="card-text"><small class="text-muted">7.80€/kg</small></p>
                  <p class="card-text">Na Quinta do Bill tens bananas que te fazem voar, voar, voar.</p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

          <div class="card h-100" style="width: 540px; height: 200px; max-width: 540px;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="batata-amarela.jpg" class="card-img-top" alt="batatas amarelas">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">Batatas amarela</h5>
                  <p class="card-text"><small class="text-muted">7.80€/kg</small></p>
                  <p class="card-text">Na Quinta do Bill tens bananas que te fazem voar, voar, voar.</p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

          <div class="card h-100" style="width: 540px; height: 200px; max-width: 540px;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="tomate.jpg" class="card-img-top" alt="Tomate">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">Tomate</h5>
                  <p class="card-text"><small class="text-muted">7.80€/kg</small></p>
                  <p class="card-text">Na Quinta do Bill tens bananas que te fazem voar, voar, voar.</p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="position-absolute top-100 start-50 translate-middle">
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>


    </div>



  </header>






</body>



</html>