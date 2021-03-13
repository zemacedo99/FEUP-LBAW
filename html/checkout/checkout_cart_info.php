<?php
include_once '../common/extras.php';
include_once 'checkout_inc_cart.php';
pageHeader("MyGarden - Cart");
navbar();
?>

<div class="container">

    <div class="col-12">

        <div class="row">
            <div class="row m-3"></div>
            <!-- Breadcrumb  -->
            <div class="d-flex justify-content-center">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" id="selectedLink" aria-current="page">Information</li>
                        <li class="breadcrumb-item"><a href="checkout_shipping_payment.php" style="text-decoration: none; color: black;">Shipping / Payment</a></li>
                    </ol>
                </nav>
            </div>
            <div class="row m-3"></div>

        </div>

        <div class="col order-1">
            <?php orderSummary(3); ?>
        </div>

        <div class="col order-6">
            <div class="row ">
                <?php

                for ($i = 0; $i < 5; $i++) {
                    cartProduct(
                        "bananas",
                        1,
                        2
                    );
                }
                ?>
            </div>
        </div>

        <div class="row m-3"></div>

        <div class="row">

            <!-- Periodic Buys -->
            <div class="col-12 col-lg-12 order-2">
                <div class="row">

                    <div class="col"></div>

                    <div class="col-12 col-lg-12">

                        <div class="row">
                            <h3 style='text-align:left;border-bottom:2px solid black;'>Periodic Buys <button type="button" class="simpleicon">history</button></h3>
                        </div>

                        <div class="row mb-3"></div>

                        <div class="row">

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
                                <button type="radio" id="simple-btt">Once</button>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
                                <button type="radio" id="simple-btt">Daily</button>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">

                                <button type="radio" id="simple-btt" data-bs-toggle="collapse" data-bs-target="#weekly">
                                    Weekly
                                </button>

                                <div class="collapse" id="weekly">
                                    <div class="card card-body">
                                        <div class="modal-body">

                                            <div class="row mb-1">
                                                <input type="radio" class="btn-check" name="options" id="Monday" autocomplete="off">
                                                <label class="btn btn-secondary" for="Monday">Monday </label>
                                            </div>

                                            <div class="row mb-1">
                                                <input type="radio" class="btn-check" name="options" id="Thuesday" autocomplete="off">
                                                <label class="btn btn-secondary" for="Thuesday">Thuesday </label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="radio" class="btn-check" name="options" id="Wednesday" autocomplete="off">
                                                <label class="btn btn-secondary" for="Wednesday">Wednesday </label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="radio" class="btn-check" name="options" id="Thursday" autocomplete="off">
                                                <label class="btn btn-secondary" for="Thursday">Thursday </label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="radio" class="btn-check" name="options" id="Friday" autocomplete="off">
                                                <label class="btn btn-secondary" for="Friday">Friday </label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="radio" class="btn-check" name="options" id="Saturday" autocomplete="off">
                                                <label class="btn btn-secondary" for="Saturday">Saturday </label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="radio" class="btn-check" name="options" id="Sunday" autocomplete="off">
                                                <label class="btn btn-secondary" for="Sunday">Sunday </label>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">

                                <button type="button" id="simple-btt" data-bs-toggle="collapse" data-bs-target="#monthly">
                                    Monthly
                                </button>

                                <div class="collapse" id="monthly">
                                    <div class="card card-body">
                                        <input class="form-control" type="date" id="example-date-input">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col"></div>

                    <div class="row m-3"></div>
                </div>

            </div>



            <!-- Cupons -->
            <div class="col-12  col-lg-12 order-3">

                <div class="row">

                    <div class="col"></div>

                    <div class="col-12 col-lg-12">

                        <div class="row">
                            <h3 style='text-align:left;border-bottom:2px solid black;'>Cupons <button type="button" class="simpleicon">redeem</button></h3>
                        </div>

                        <div class="row mt-3"></div>

                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="CODE">
                            </div>
                            <div class="col-3 text-center">
                                <button type="button" class="simpleicon">add</button>
                            </div>
                        </div>

                        <div class="row mt-3"></div>

                        <div class="row row-cols-1 row-cols-md-2 g-4">

                            <?php
                            for ($i = 0; $i < 2; $i++) {
                                cuponCard(
                                    "SUMMER 2021",
                                    10,
                                    "2/5/2021",
                                );
                            }
                            ?>
                        </div>

                        <div class="row m-3"></div>

                    </div>
                    <div class="col"></div>

                    <div class="row m-3"></div>
                </div>
            </div>


        </div>


        <?php orderTotal(8.37); ?>


        <div class="col-12">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <a href="../checkout/checkout_shipping_payment.php">
                        <button type="button" class="btn btn-primary"> Continue</button>
                    </a>
                </div>

            </div>
        </div>

    </div>

</div>

<?php
footer();
?>