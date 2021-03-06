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
                            <a class="nav-link" id="navLinks" href="supplier_all_prod.php">Products</a>
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



   
    <div class="container">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">

                <div class="row mt-3"></div>
                <div class="row mt-3"></div>
                <!-- Breadcrumb  -->
                <div class="d-flex justify-content-center">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a id="navLinks" href="cart_information.php">Information</a></li>
                            <li class="breadcrumb-item active"  id="selectedLink" aria-current="page">Shipping / Payment</li>
                        </ol>
                    </nav>
                </div>
                <div class="row mt-3"></div>
                <div class="row mt-3"></div>

                <!-- ****************** Left Side ****************** -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style='border-right:2px solid green;'>
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h3 style='text-align:left;border-bottom:2px solid black;'>Shipping Address</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3"></div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
                                <p> Once </p>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
                                <p> Daily </p>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
                                <p> Weekly </p>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
                                <p> Monthly </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ****************** Right Side ****************** -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style='border-left:2px solid green;'>

                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h3 style='text-align:left;border-bottom:2px solid black;'>Payment Method</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3"></div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                <input type="text" class="form-control" placeholder="CODE">
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                                <button type="button" id="simpleicon">add</button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3"></div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <img src="cupon.jpg" class="img-fluid" alt="cupon" style=" margin-left:auto; margin-right:auto;width:40em;height:10em;">
                            </div>
                            
                            <div class="card-img-overlay">
                                <div class="text-center">
                                    <br>
                                    <h5 class="card-title">SUMMER 2021</h5>
                                    <p class="card-text">10%</p>
                                    <div class="mx-auto" id="horizontal_line"></div>
                                    <p class="card-text">*Code valid for orders over 5€</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Valid until 2/5/2021</small>
                            </div>
                        </div>
                    </div>

                </div>

                <br><br>

            </div>
        </div>




</body>



</html>