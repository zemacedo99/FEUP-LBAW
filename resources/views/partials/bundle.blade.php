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
        <div class="d-flex justify-content-start">Winter Bundle</div>
    </div>

    <div class="col-4 d-flex justify-content-center">
        <a href="create_edit_bundle.php"> <button type="button" class="simpleicon">edit</button></a>
    </div>

    <div class="col-4">
        <div class="d-flex justify-content-end">4.5€</div>
    </div>

</div>


<?php function bundleProductsImage($productname)
{
    ?>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
        <img src="../images/<?= $productname ?>.jpg" alt="<?= $productname ?>" class="img-fluid img-thumbnail" style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
    </div>
<?php
}
?>
