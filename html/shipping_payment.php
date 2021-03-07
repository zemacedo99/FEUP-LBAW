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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

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
                            <li class="breadcrumb-item active" id="selectedLink" aria-current="page">Shipping / Payment</li>
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
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>


                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingFirstName" placeholder="FirstName">
                                <label for="floatingFirstName">First Name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingLastName" placeholder="LastName">
                                <label for="floatingLastName">Last Name</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingAddress" placeholder="FirstName">
                                <label for="floatingAddress">Address</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingDoor" placeholder="LastName">
                                <label for="floatingDoor">Door Nº</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingZipcode" placeholder="FirstName">
                                <label for="floatingZipcode">Zip Code</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingDistrict" placeholder="LastName">
                                <label for="floatingDistrict">District</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingCity" placeholder="LastName">
                                <label for="floatingCity">City</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingCountry" placeholder="FirstName">
                                <label for="floatingCountry">Country</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingPhone" placeholder="FirstName">
                                <label for="floatingPhone">Phone Number</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                <div class="form-check form-switch">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Save data for future purchases</label>
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                                </div>
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
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="card mb-3 d-flex justify-content-center align-items-center" style="height: 60px;">
                                    <button type="button" id="simple-btt">PayPal</button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="card mb-3 d-flex justify-content-center align-items-center" style="height: 60px;">
                                    <button type="button" id="simple-btt">Credit</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>

                    <div class="col-12">
                        <h3 class="mb-3 " style='text-align:left;border-bottom:2px solid black;'>Payment Information</h3>

                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-2 col-md-2">
                                    <img src="https://via.placeholder.com/80x80" alt="...">
                                </div>
                                <div class="col-8 col-md-9">
                                    <div class="card-body">
                                        <h6 class="card-title">Card Holder</h6>
                                        <p class="card-text">Visa car Ending in **69</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 d-flex justify-content-center align-items-center" style="height: 60px;">
                            <p class="card-text">Add new Card <i class="bi bi-plus"></i></p>
                        </div>

                    </div>



                </div>

                <br><br>

                <div class="row mt-3"></div>
                <div class="row mt-3"></div>


                <div class="row">

                    <div class="col-6">
                        <div class="d-flex justify-content-start">
                            <h4 style='text-align:center;'>Total </h4>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex justify-content-end">
                            <h4 style='text-align:center;'>8.37€ </h4>
                        </div>
                    </div>

                </div>

                <div class="row mt-3"></div>
                <div class="row mt-3"></div>
                <div class="row mt-3"></div>


                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">

                        <div class="col-6">
                            <div class="d-flex justify-content-center">
                                <button type="button" class="mainbtt"> <a id="navLinks" href="cart_information.php">Info</a></button>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex justify-content-center">
                                <button type="button" class="mainbtt"> <a id="navLinks" href="#">Finish</a></button>
                            </div>
                        </div>


                    </div>
                </div>



            </div>
        </div>


    </div>




</body>



</html>