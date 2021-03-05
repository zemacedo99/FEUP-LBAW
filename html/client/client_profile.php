<?php
include '../common/head.php';
include '../common/navbar.php';
?>

<div class="container">
    <div class="row row-cols-1 row-cols-sm-3 mt-3 d-flex justify-content-center align-items-center" style="height: 200px;">
        <div class="col col-sm-1" style="width: 200px;">
            <img src="../images/img_avatar.png" class="rounded-circle img-fluid">
        </div>
        <div class="col col-sm-3 col-md-5 col-lg-6 col-xl-6 col-xxl-7 d-flex justify-content-center justify-content-sm-start ps-3 fs-2">André Gomes</div>
        <div class="col col-sm-4 col-md-3 d-none d-sm-block text-center">
            <button type="button" class="btn btn-secondary"><i class="bi bi-list"></i> Edit Profile</button>
        </div>
    </div>

    <div class="row mt-4 ps-0 ps-lg-2">
        <ul class="nav nav-pills mb-3 d-flex justify-content-center justify-content-md-start" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-purchase-history-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-history" type="button" role="tab" aria-controls="pills-purchase-history" aria-selected="true">Purchase History</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-favorites-tab" data-bs-toggle="pill" data-bs-target="#pills-favorites" type="button" role="tab" aria-controls="pills-favorites" aria-selected="false">Favorites</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-periodic-buys-tab" data-bs-toggle="pill" data-bs-target="#pills-periodic-buys" type="button" role="tab" aria-controls="pills-periodic-buys" aria-selected="false">Periodic Buys</button>
            </li>
        </ul>
    </div>

    <div class="tab-content ps-5" id="pills-tabContent">
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">Profile Info</div>
        <div class="tab-pane fade show active" id="pills-purchase-history" role="tabpanel" aria-labelledby="pills-purchase-history-tab">Purchase History Info</div>
        <div class="tab-pane fade" id="pills-favorites" role="tabpanel" aria-labelledby="pills-favorites-tab">Favorites Info</div>
        <div class="tab-pane fade" id="pills-periodic-buys" role="tabpanel" aria-labelledby="pills-periodic-buys-tab">Periodic Buys Info</div>
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