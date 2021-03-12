<?php
function supplierBundle($bundlename, $price)
{
?>
    <div class="row mt-3"></div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style='border:1px solid silver;'>
        <div class="row">

            <?= bundleProductsImage("bananas") ?>
            <?= bundleProductsImage("tomate") ?>
            <?= bundleProductsImage("tomate") ?>
            <?= bundleProductsImage("batata_vermelha") ?>
            <?= bundleProductsImage("bananas") ?>

        </div>

    </div>
    <div class="row">

        <div class="col-6">
            <div class="d-flex justify-content-start"><?= $bundlename ?></div>
        </div>

        <div class="col-6">
            <div class="d-flex justify-content-end"><?= $price ?>€</div>
        </div>

    </div>

<?php
}
?>

<?php
function bundleProductsImage($productname)
{
?>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
        <img src="../images/<?= $productname ?>.jpg" alt="<?= $productname ?>" class="img-fluid" style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
    </div>
<?php
}
?>

<?php
function cuponCard($name, $discount, $date, $done)
{
?>
    <div class="col-lg-3 col-md-4 col-10 mx-auto">
        <div class="p-3">
            <div class="card">

                <?= cuponImage($done) ?>

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