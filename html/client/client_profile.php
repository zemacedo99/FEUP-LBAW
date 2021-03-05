<?php
include '../common/head.php';
include '../common/navbar.php';
?>

<div class="container">

    <div class="row row-cols-1 row-cols-lg-3 mt-3 d-flex justify-content-center align-items-center" style="height: 200px;">
        <div class="col col-sm-1" style="width: 200px;">
            <img src="../images/img_avatar.png" class="rounded-circle img-fluid">
        </div>
        <div class="col col-sm-3 col-md-8 col-lg-9 col-xl-9 col-xxl-10 d-flex justify-content-center justify-content-sm-start ps-3 fs-2">André Gomes</div>
    </div>

    <div class="row mt-4 ps-0 ps-sm-4">
        <ul class="nav nav-pills mb-3 d-flex justify-content-center justify-content-sm-start" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-purchase-history-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-history" type="button" role="tab" aria-controls="pills-purchase-history" aria-selected="true">Purchase History</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-favorites-tab" data-bs-toggle="pill" data-bs-target="#pills-favorites" type="button" role="tab" aria-controls="pills-favorites" aria-selected="false">Favorites</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-periodic-buys-tab" data-bs-toggle="pill" data-bs-target="#pills-periodic-buys" type="button" role="tab" aria-controls="pills-periodic-buys" aria-selected="false">Periodic Buys</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile1 pills-profile2" aria-selected="false">Profile</button>
            </li>
        </ul>
    </div>

    <div class="tab-content ps-3" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-purchase-history" role="tabpanel" aria-labelledby="pills-purchase-history-tab"><?php include './client_history.php'; ?></div>
        <div class="tab-pane fade" id="pills-favorites" role="tabpanel" aria-labelledby="pills-favorites-tab"><?php include './client_favorites.php'; ?></div>
        <div class="tab-pane fade" id="pills-periodic-buys" role="tabpanel" aria-labelledby="pills-periodic-buys-tab"><?php include './client_periodic.php'; ?></div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"><?php include './client_edit_profile.php'; ?></div>
    </div>

</div>

<?php include '../common/end.php' ?>
