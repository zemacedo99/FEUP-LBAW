<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <!-- material icons-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link href="sytle.css" rel="stylesheet">
  <title>MyGarden</title>
</head>


<body>
  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
      crossorigin="anonymous"></script>
      
  <header>

    <nav class="navbar navbar-expand-sm navbar-light">
      <div class="container-fluid">
      <a class = "navbar-brand" href="index.php"> <img alt="Logo" src="logo.png" width="100" height="25"> </a>
    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!-- <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li> -->
            <li class="nav-item">
              <a class="nav-link" id = "navLinks" href="#">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id = "navLinks" href="#">Stores</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id = "navLinks" href="#">About Us</a>
            </li>

        </ul>

        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button type="button" id = "headericon">search</button>
        </form>
      </div>

      <div class="navbar-nav ms-auto">
        <div class="col align-items-end">
        <button type="button" id = "headericon">account_circle</button>
        <button type="button" id = "headericon">shopping_cart</button>
        </div>
      </div>
      </div>
    </nav>


    <div class="d-flex flex-row bd-highlight mb-3">
      <div class="p-2 bd-highlight"> <img src="quinta_do_bil.png" alt="QuintaDoBill" class="img-thumbnail" width="100" height="25"> </div>
      <div class="p-2 bd-highlight">Quinta do Bill</div>
    </div>

    
    <h3> All Products </h3>

    <div class="row row-cols-1 row-cols-md-3 g-4">
      <div class="col">
        <div class="card h-100">
          <img src="bananas.jpg" class="card-img-top" alt="bananas" >
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
        <img src="bananas.jpg" class="card-img-top" alt="bananas">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a short card.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
        <img src="bananas.jpg" class="card-img-top" alt="bananas">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <img src="bananas.jpg" class="card-img-top" alt="bananas">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- <footer>

    <div id="navfooter">
      <img src="logo.png" class="img-fluid" alt="Logo">
      <div class="d-flex flex-row-reverse">
        <div class="row">
          <button type="button" id = "footericon">thumb_up</button>
          <button type="button" id = "footericon">check_circle_outline</button>
          <button type="button"  id = "footericon">star_rate</button>
          <button type="button"  id = "footericon">mdi-bell</button>
          <button type="button"  id = "footericon">favorite</button>
        </div>
    </div>
    </div>
    
  </footer>
 -->







</body>



</html>