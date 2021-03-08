<?php
include '../common/head.php';
include '../common/navbar.php';
?>

<div class="container">
    <h3 class="mt-3 mb-3">Site Map</h3>

    <div class="row">
        <div class="list-group col-3">
            <a href="../client/client_profile.php" class="list-group-item list-group-item-action fw-bold">Client</a>
            <a href="../admin/dashboard.php" class="list-group-item list-group-item-action fw-bold">Admin</a>
            <a href="../admin/view_prods.php" class="list-group-item list-group-item-action">Admin - Products</a>
            <a href="../admin/view_req.php" class="list-group-item list-group-item-action">Admin - Supplier Requests</a>
            <a href="../admin/view_users.php" class="list-group-item list-group-item-action">Admin - Users</a>
        </div>
    </div>

</div>


<?php include '../common/end.php' ?>