<?php
include '../common/head.php';
include '../common/navbar.php';
?>

<div class="container">
    <div class="row row-cols-1 row-cols-sm-3 mt-3 d-flex justify-content-center align-items-center" style="height: 200px;">
        <div class="col col-sm-1" style="width: 200px;">
            <img src="../images/img_avatar.png" class="rounded-circle img-fluid">
        </div>
        <div class="col col-sm-3 col-md-5 d-flex justify-content-center justify-content-sm-start ps-3 fs-2">André Gomes</div>
        <div class="col col-sm-4 col-md-3 d-none d-sm-block text-center">
            <button type="button" class="btn btn-secondary"><i class="bi bi-list"></i> Edit Profile</button>
        </div>
    </div>


    <!-- <div class="row row-cols-1 row-cols-sm-3 mt-3">
        <div class="col col-sm-2 col-md-4 d-flex justify-content-center">
            <img src="../images/img_avatar.png" class="rounded-circle w-50 img-fluid">
        </div>
        <div class="col d-flex justify-content-center align-items-center justify-content-sm-start align-items-sm-center mt-3 mt-sm-0">
            <p class="fs-3">André Gomes</p>
        </div>
        <div class="col align-self-center d-none d-sm-block">
            <button type="button" class="btn btn-secondary pull-right"><i class="bi bi-list"></i> Edit Profile</button>
        </div>
    </div> -->

</div>

<?php include '../common/end.php' ?>