<?php
include_once '../common/extras.php';
pageHeader("MyGarden - Edit Card");
navbar();

include 'checkout_inc_pay_info.php';
?>

<div class="row mt-3"></div>
<div class="row mt-3"></div>
<div class="row mt-3"></div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-secondary btn-sm"><i class="bi bi-trash"></i> Delete Account</button>
        </div>
    </div>
</div>

<div class="row mt-3"></div>
<div class="row mt-3"></div>
<div class="row mt-3"></div>
<div class="row mt-3"></div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="d-flex justify-content-center">
            <button type="button" class="mainbtt"> <a id="navLinks" href="checkout_shipping_payment.php">Confirm</a></button>
        </div>
    </div>
</div>

<?php
footer();
?>