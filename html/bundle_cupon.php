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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
  </script>

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

        <!-- navbar profile and cart buttons -->
        <div class="navbar-nav ms-auto">
          <div class="col align-items-end">
            <button type="button" id="headericon">account_circle</button>
            <button type="button" id="headericon">shopping_cart</button>
          </div>
        </div>
    </nav>

  </header>



  <!-- Bundle and Cupon buttons -->
  <div class="container">


    <!-- vertical line -->
    <!-- <div class="position-absolute top-50 start-50 translate-middle">
      <div id="vertical_line"></div>
    </div> -->

    <div class="row mt-3"></div>
    <div class="row mt-3"></div>
    <div class="row mt-3"></div>

    <div class="row mb-3">
      <!-- ****************** Left Side ****************** -->
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="border-right:2px solid green;">

        <div class="d-flex justify-content-center">
          <button type="button" class="mainbtt"> Bundles</button>
          <button type="button" class="mainbtt" id="mainbtticon">add</button>
        </div>

        <div class="row mt-3"></div>
        <div class="row mt-3"></div>
        <div class="row mt-3"></div>


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style='border:1px solid silver;'>
          <div class="row">


            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
              <img src="bananas.jpg" alt="bananas"  class="img-fluid"  style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
              <img src="batata_vermelha.jpg" alt="bananas"  class="img-fluid"  style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
              <img src="tomate.jpg" alt="bananas"  class="img-fluid"  style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
              <img src="batata_vermelha.jpg" alt="bananas"  class="img-fluid"  style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
              <img src="bananas.jpg" alt="bananas"  class="img-fluid" style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
            </div>

          </div>

        </div>
        <div class="row">

          <div class="col-6">
            <div class="d-flex justify-content-start">Winter Bundle</div>
          </div>

          <div class="col-6">
            <div class="d-flex justify-content-end">30.50€</div>
          </div>

        </div>
        <br><br>



        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style='border:1px solid silver;'>
          <div class="row">

          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
              <img src="bananas.jpg" alt="bananas"  class="img-fluid"  style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
              <img src="batata_vermelha.jpg" alt="bananas"  class="img-fluid"  style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
              <img src="tomate.jpg" alt="bananas"  class="img-fluid"  style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
              <img src="batata_vermelha.jpg" alt="bananas"  class="img-fluid"  style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
              <img src="bananas.jpg" alt="bananas"   class="img-fluid"  style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
            </div>


          </div>
        </div>
        <div class="row">

          <div class="col-6">
            <div class="d-flex justify-content-start">Winter Bundle</div>
          </div>

          <div class="col-6">
            <div class="d-flex justify-content-end">30.50€</div>
          </div>

        </div>
        <br><br>


      </div>

      <!-- ****************** Right Side ****************** -->
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="d-flex justify-content-center">
          <button type="button" class="mainbtt">Cupons</button>
          <button type="button" class="mainbtt" id="mainbtticon">add</button>
        </div>
        <div class="row mt-3"></div>
        <div class="row mt-3"></div>
        <div class="row mt-3"></div>


        <div class="row row-cols-1 row-cols-md-2 g-4">

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="p-3">
              <div class="card">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <img src="cupon.jpg" class="img-fluid" alt="cupon" style=" margin-left:auto; margin-right:auto;width:40em;height:10em;">
                            </div>
                <div class="card-img-overlay">
                  <div class="text-center">
                    <br><br>
                    <h5 class="card-title">SUMMER 2021</h5>
                    <p class="card-text">10%</p>
                  </div>
                </div>
                <div class="card-footer">
                  <small class="text-muted">Valid until 2/5/2021</small>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="p-3">
              <div class="card">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <img src="cupon_done.jpg" class="img-fluid" alt="cupon" style=" margin-left:auto; margin-right:auto;width:40em;height:10em;">
                            </div>
                <div class="card-img-overlay">
                  <div class="text-center">
                    <br><br>
                    <h5 class="card-title">SUMMER 2020</h5>
                    <p class="card-text">10%</p>
                  </div>
                </div>
                <div class="card-footer">
                  <small class="text-muted">Valid until 2/5/2020</small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="p-3">
              <div class="card">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <img src="cupon_done.jpg" class="img-fluid" alt="cupon" style=" margin-left:auto; margin-right:auto;width:40em;height:10em;">
                            </div>
                <div class="card-img-overlay">
                  <div class="text-center">
                    <br><br>
                    <h5 class="card-title">SUMMER 2019</h5>
                    <p class="card-text">10%</p>
                  </div>
                </div>
                <div class="card-footer">
                  <small class="text-muted">Valid until 2/5/2019</small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="p-3">
              <div class="card">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <img src="cupon_done.jpg" class="img-fluid" alt="cupon" style=" margin-left:auto; margin-right:auto;width:40em;height:10em;">
                            </div>
                <div class="card-img-overlay">
                  <div class="text-center">
                    <br><br>
                    <h5 class="card-title">SUMMER 2018</h5>
                    <p class="card-text">10%</p>
                  </div>
                </div>
                <div class="card-footer">
                  <small class="text-muted">Valid until 2/5/2018</small>
                </div>
              </div>
            </div>  
          </div>

        </div>
      </div>



    </div>
  </div>
  </div>






</body>



</html>