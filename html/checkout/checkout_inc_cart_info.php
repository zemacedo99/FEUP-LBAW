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
                        <h4 class="card-title text-center mb-3" ><?= $name ?></h4>

                        
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

