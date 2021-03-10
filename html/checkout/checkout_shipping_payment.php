<?php
include_once '../common/extras.php';
pageHeader("MyGarden - Shipping/Payment");
navbar();
?>

<div class="container">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">

            <div class="row mt-3"></div>
            <div class="row mt-3"></div>
            <!-- Breadcrumb  -->
            <div class="d-flex justify-content-center">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a id="navLinks" href="checkout_cart_info.php">Information</a></li>
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
                                    <p class="card-text">Visa car Ending in **69 </p>
                                </div>
                            </div>
                            <div class="col-2 col-md-1">
                                <a href="checkout_edit_card.php"> <button type="button" id="simpleicon">edit</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 d-flex justify-content-center align-items-center" style="height: 60px;">
                        <a class="nav-link" id="navLinks" href="checkout_add_card.php">
                            <p class="card-text">Add new Card <i class="bi bi-plus"></i></p>
                        </a>

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
                            <button type="button" class="mainbtt"> <a id="navLinks" href="checkout_cart_info.php">Info</a></button>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex justify-content-center">
                            <!-- Button trigger modal -->
                            <button type="button" class="mainbtt" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                Finish
                            </button>
                            <!-- <button type="button" class="mainbtt"> <a id="navLinks" href="#">Finish</a></button> -->
                        </div>
                    </div>


                </div>
            </div>




            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="d-flex justify-content-center">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">THANKS!</h5>
                            </div>
                        </div>
                        <div class="modal-body text-center">
                            Success <br>
                            Your order is completed
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="modal-footer">
                                <button type="button" class="mainbtt"><a id="navLinks" href="../home.php">Keep Shopping</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


</div>

<?php
footer();
?>