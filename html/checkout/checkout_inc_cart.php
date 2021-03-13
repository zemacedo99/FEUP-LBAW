<?php
function orderSummary($n)
{
?>
    <div class="row" style='border-bottom:2px solid black;'>
        <div class="col-6">
            <h3 style='text-align:left;'>Order Summary</h3>
        </div>
        <div class="col-6">
            <h3 style='text-align:right;'><?= $n ?> items in your cart</h3>
        </div>
    </div>
<?php
}
?>


<?php
function cartProduct($name, $total, $price)
{
?>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="card m-3">
            <div class="row">
                <div class="col-lg-4">
                    <img src="../images/<?= $name ?>.jpg" class="rounded mx-auto d-block" alt=<?= $name ?> style="margin-left:auto; margin-right:auto;width:8em;height:8em;">
                </div>
                <div class="col-lg-8">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-3"><?= $name ?></h4>


                        <div class="row text-center">
                            <div class="col-xl-4">
                                <h5 class="card-text text-muted">Total: <?= $total ?></h5>
                            </div>

                            <div class="col-xl-4">
                                <button type="button" id="simpleicon">add_circle_outline</button>
                                <button type="button" id="simpleicon"> remove_circle_outline</button>
                            </div>

                            <div class="col-xl-4">
                                <h5 class="card-text"><?= $price ?>€</h5>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>

<?php
}
?>

<?php
function cuponCard($name, $discount, $date)
{
?>
    <!-- <div class="col-lg-12 col-10 mx-auto"> -->
    <div class="col-lg-4 col-10 mx-auto">
        <div class="p-3">
            <div class="card">

                <?= cuponImage("cupon") ?>

                <div class="card-img-overlay">
                    <div class="text-center">
                        <br><br>
                        <h5 class="card-title"><?= $name ?></h5>
                        <p class="card-text"><?= $discount ?>%</p>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Valid until <?= $date ?></small>
                </div>
            </div>
        </div>
    </div>


<?php
}
?>


<?php
function cuponImage($done)
{
?>
    <div class="col">
        <img src="../images/<?= $done ?>.jpg" class="img-fluid" alt="<?= $done ?>" style="margin-left:auto; margin-right:auto;width:40em;height:10em;">
    </div>
<?php
}
?>


<?php
function orderTotal($n)
{
?>
    <div class="col-12">

        <!-- <div class="col-6">
            <div class="d-flex justify-content-start">
                <h4 style='text-align:center;'>Total </h4>
            </div>
        </div>

        <div class="col-6">
            <div class="d-flex justify-content-end">
                <h4 style='text-align:center;'><?= $n ?>€ </h4>
            </div>
        </div> -->

        <h4 style='text-align:center;'>Total: <?= $n ?> €</h4>
        <div class="row mb-3"></div>


    </div>
<?php
}
?>

<?php
function paymentCard($holder, $number)
{
?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-2 col-md-2">
                <img src="https://via.placeholder.com/80x80" alt="...">
            </div>
            <div class="col-8 col-md-9">
                <div class="card-body">
                    <h6 class="card-title"><?= $holder ?></h6>
                    <p class="card-text">Visa car Ending in **<?= $number ?> </p>
                </div>
            </div>
            <div class="col-2 col-md-1">
                <a href="checkout_edit_card.php"> <button type="button" id="simpleicon">edit</button></a>
            </div>
        </div>
    </div>
<?php
}
?>