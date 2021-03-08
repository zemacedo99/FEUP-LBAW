<?php 
include_once '../credentials/login.php';
addLogin();
?>

<nav class="navbar navbar-expand-md navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php"> <img alt="Logo" src="../images/logo.png" width="100" height="25"> </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" id="navLinks" href="../misc/productList.php">Products</a>
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" id="navLinks" href="../misc/productList.php">Stores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="navLinks" href="../misc/about_us.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="navLinks" href="../misc/site_map.php">SiteMap</a>
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
                <button type="button" id="headericon" data-bs-toggle="modal" data-bs-target="#loginModal">account_circle</button>
                <a href="../checkout/cart_information.php"><button type="button" id="headericon">shopping_cart</button></a>  
            </div>
        </div>
</nav>

<!-- <nav class="navbar navbar-expand-md navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/misc/home_page.php">
      <img src="../images/favicon.ico" alt="" width="30" height="24" class="d-inline-block align-top">
      MyGarden
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="#">Products</a>
        <a class="nav-link" href="#">Stores</a>
        <a class="nav-link" href="/misc/about_us.php">About Us</a>
        <a class="nav-link d-block d-md-none" href="#">Client</a>
        <a class="nav-link d-block d-md-none" href="#">Cart</a>
      </div>
    </div>
    <a href="../client/client_profile.php" class="d-none d-md-inline-block"><i class="bi bi-person fs-2"></i></a>
    <a href="#" class="d-none d-md-inline-block"><i class="bi bi-cart3 fs-2"></i></a>
  </div>
</nav>  -->