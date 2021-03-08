<?php
include '../common/head.php';
include '../common/navbar.php';
include 'payment_info.php';
?>

<div class="row mt-3"></div>
<div class="row mt-3"></div>
<div class="row mt-3"></div>

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


<div class="row mt-3"></div>
<div class="row mt-3"></div>
<div class="row mt-3"></div>
<div class="row mt-3"></div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="d-flex justify-content-center">
            <button type="button" class="mainbtt"> <a id="navLinks" href="shipping_payment.php">Confirm</a></button>
        </div>
    </div>
</div>




<?php
include '../common/end.php'
?>