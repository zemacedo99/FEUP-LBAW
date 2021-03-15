<?php function supplierBundle($bundlename, $price)
{ ?>
    <div class="row m-3"></div>
    <div class="col-12" style='border:1px solid silver;'>
        <div class="row">

            <?= bundleProductsImage("bananas") ?>
            <?= bundleProductsImage("tomate") ?>
            <?= bundleProductsImage("tomate") ?>
            <?= bundleProductsImage("batata_vermelha") ?>
            <?= bundleProductsImage("bananas") ?>

        </div>

    </div>
    <div class="row">

        <div class="col-4">
            <div class="d-flex justify-content-start"><?= $bundlename ?></div>
        </div>

        <div class="col-4 d-flex justify-content-center">
            <a href="create_edit_bundle.php"> <button type="button" class="simpleicon">edit</button></a>
        </div>

        <div class="col-4">
            <div class="d-flex justify-content-end"><?= $price ?>€</div>
        </div>


    </div>

<?php } ?>

<?php function bundleProductsImage($productname)
{ ?>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
        <img src="../images/<?= $productname ?>.jpg" alt="<?= $productname ?>" class="img-fluid img-thumbnail" style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
    </div>
<?php } ?>

<?php function cuponCard($name, $discount, $date, $done)
{ ?>
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
<?php } ?>

<?php function cuponImage($done)
{ ?>
    <div class="col">
        <img src="../images/<?= $done ?>.jpg" class="img-fluid" alt="<?= $done ?>" style="margin-left:auto; margin-right:auto;width:40em;height:10em;">
    </div>
<?php } ?>

<?php function bundleItem()
{ ?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="../images/red_apple.jpg" class="img-fluid" alt="An apple" style="max-height: 200px">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Red apple</h5>
                    <p class="card-text">Total: 5</p>
                    <span>
                        <button type="button" class="btn btn-outline-secondary btn-sm"><i class="bi bi-plus-circle"></i></button>
                        <button type="button" class="btn btn-outline-secondary btn-sm"><i class="bi bi-dash-circle"></i></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>