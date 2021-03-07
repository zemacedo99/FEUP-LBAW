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
                <a class="navbar-brand" href="index.php"> <img alt="Logo" src="../images/logo.png" width="100" height="25"> </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li> -->
                        <li class="nav-item">
                            <a class="nav-link" id="navLinks" href="supplier/bundles_and_cupons.php">Supplier Bundles and Cupons</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="navLinks" href="supplier/all_products.php">Supplier All Products</a>
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
                        <button type="button" id="headericon"> <a class="nav-link" id="navLinks" href="checkout/cart_information.php">shopping_cart </a></button>
                    </div>
                </div>
        </nav>

    </header>


    <div class="container">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">

                <div class="row mt-3"></div>
                <div class="row mt-3"></div>
                <div class="d-flex justify-content-center">
                    <h1> Home Page </h1>
                </div>

                <div class="row mt-3"></div>
                <div class="row mt-3"></div>
                <div class="row mt-3"></div>
                <div class="row mt-3"></div>
                
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php
    include 'common/end.php'
    ?>