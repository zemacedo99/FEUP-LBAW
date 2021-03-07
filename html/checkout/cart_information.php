<?php
include '../common/head.php';
include '../common/navbar.php';
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
                        <li class="breadcrumb-item active" id="selectedLink" aria-current="page">Information</li>
                        <li class="breadcrumb-item"><a id="navLinks" href="shipping_payment.php">Shipping / Payment</a></li>
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
                            <h3 style='text-align:left;border-bottom:2px solid black;'>Periodic Buys <button type="button" id="simpleicon">history</button></h3>
                        </div>
                    </div>
                </div>
                <div class="row mt-3"></div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
                            <!-- <p> Once </p> -->
                            <button type="button" id="simple-btt">Once</button>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
                            <button type="button" id="simple-btt">Daily</button>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
                            <!-- <label for="example-week-input" class="col-2 col-form-label">Weekly</label> -->
                            <!-- <input class="form-control" type="week" id="example-week-input"> -->
                            <!-- <button type="button" id="simple-btt">Weekly</button> -->

                            <!-- Button trigger modal -->
                            <button type="button" id="simple-btt" data-bs-toggle="modal" data-bs-target="#WeeklyModal">
                                Weekly
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="WeeklyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        
                                        <div class="modal-body">
                                        <a href="#" role="button" id="simple-btt" title="Popover title" data-bs-content="Popover body content is set in this attribute.">Monday</a> <br>
                                        <a href="#" role="button" id="simple-btt" title="Popover title" data-bs-content="Popover body content is set in this attribute.">Thuesday</a><br>
                                        <a href="#" role="button" id="simple-btt" title="Popover title" data-bs-content="Popover body content is set in this attribute.">Wednesday</a><br>
                                        <a href="#" role="button" id="simple-btt" title="Popover title" data-bs-content="Popover body content is set in this attribute.">Thursday</a><br>
                                        <a href="#" role="button" id="simple-btt" title="Popover title" data-bs-content="Popover body content is set in this attribute.">Friday</a><br>
                                        <a href="#" role="button" id="simple-btt" title="Popover title" data-bs-content="Popover body content is set in this attribute.">Saturday</a><br>
                                        <a href="#" role="button" id="simple-btt" title="Popover title" data-bs-content="Popover body content is set in this attribute.">Sunday</a><br>

                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
                            <!-- <label for="example-date-input" class="col-2 col-form-label">Monthly</label> -->
                            <button type="button" id="simple-btt">Monthly</button>
                            <input class="form-control" type="date" id="example-date-input">

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
                            <h3 style='text-align:left;border-bottom:2px solid black;'>Cupons <button type="button" id="simpleicon">redeem</button></h3>
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
                            <img src="../images/cupon.jpg" class="img-fluid" alt="cupon" style=" margin-left:auto; margin-right:auto;width:40em;height:10em;">
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


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">

            <div class="row mt-3"></div>
            <div class="row mt-3"></div>
            <div class="row mt-3"></div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="row" style='border-bottom:2px solid black;'>

                            <div class="col-6">
                                <div class="d-flex justify-content-start">
                                    <h3 style='text-align:right;'>Order Summary</h3>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="d-flex justify-content-end">
                                    <h4 style='text-align:right;'>3 items in your cart</h4>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
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

        </div>



    </div>



    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">

            <div class="d-flex justify-content-center">
                <button type="button" class="mainbtt"> <a id="navLinks" href="shipping_payment.php">Continue</a></button>
            </div>
        </div>
    </div>


    <div class="row mt-3"></div>
    <div class="row mt-3"></div>
    <div class="row mt-3"></div>


    <div class="row mt-3"></div>
    <div class="row mt-3"></div>




    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                            <img src="../images/bananas.jpg" alt="bananas" style=" margin-left:auto; margin-right:auto;width:5.5em;height:7em;">
                        </div>
                        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
                            <div class="card-body">

                                <div class="d-flex justify-content-between justify-content-md-start">
                                    <h4 class="card-title">Maças Vermelhas</h4>
                                    <br>
                                    <br>
                                    <br>
                                    <i class="bi bi-cart-plus ps-md-4"></i>
                                </div>

                                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <h5 class="card-text text-muted">Total: 1 </h5>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <button type="button" id="simpleicon">add_circle_outline</button>
                                            <button type="button" id="simpleicon"> remove_circle_outline</button>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="row row-cols-1 row-cols-md-2">
                                                <h4 class="card-text">2,40€</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                            <img src="../images/bananas.jpg" alt="bananas" style=" margin-left:auto; margin-right:auto;width:5.5em;height:7em;">
                        </div>
                        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
                            <div class="card-body">

                                <div class="d-flex justify-content-between justify-content-md-start">
                                    <h4 class="card-title">Maças Vermelhas</h4>
                                    <br>
                                    <br>
                                    <br>
                                    <i class="bi bi-cart-plus ps-md-4"></i>
                                </div>

                                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <h5 class="card-text text-muted">Total: 1 </h5>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <button type="button" id="simpleicon">add_circle_outline</button>
                                            <button type="button" id="simpleicon"> remove_circle_outline</button>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="row row-cols-1 row-cols-md-2">
                                                <h4 class="card-text">2,40€</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                            <img src="../images/bananas.jpg" alt="bananas" style=" margin-left:auto; margin-right:auto;width:5.5em;height:7em;">
                        </div>
                        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
                            <div class="card-body">

                                <div class="d-flex justify-content-between justify-content-md-start">
                                    <h4 class="card-title">Maças Vermelhas</h4>
                                    <br>
                                    <br>
                                    <br>
                                    <i class="bi bi-cart-plus ps-md-4"></i>
                                </div>

                                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <h5 class="card-text text-muted">Total: 1 </h5>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <button type="button" id="simpleicon">add_circle_outline</button>
                                            <button type="button" id="simpleicon"> remove_circle_outline</button>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="row row-cols-1 row-cols-md-2">
                                                <h4 class="card-text">2,40€</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                            <img src="../images/bananas.jpg" alt="bananas" style=" margin-left:auto; margin-right:auto;width:5.5em;height:7em;">
                        </div>
                        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
                            <div class="card-body">

                                <div class="d-flex justify-content-between justify-content-md-start">
                                    <h4 class="card-title">Maças Vermelhas</h4>
                                    <br>
                                    <br>
                                    <br>
                                    <i class="bi bi-cart-plus ps-md-4"></i>
                                </div>

                                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <h5 class="card-text text-muted">Total: 1 </h5>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <button type="button" id="simpleicon">add_circle_outline</button>
                                            <button type="button" id="simpleicon"> remove_circle_outline</button>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="row row-cols-1 row-cols-md-2">
                                                <h4 class="card-text">2,40€</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<?php
include '../common/end.php'
?>