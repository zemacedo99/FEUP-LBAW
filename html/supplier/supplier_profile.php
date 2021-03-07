<?php
include '../common/head.php';
include '../common/navbar.php';
?>

<ul class="nav nav-tabs row" id="SupplierTab" role="tablist">
    <li class="col-6 nav-item p-0" role="presentation">
        <button class="col-12 nav-link ps-4 active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Profile</button>
    </li>
    <li class="col-6 nav-item p-0" role="presentation">
        <button class="col-12 nav-link pe-4" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-controls="products" aria-selected="false">Products</button>
    </li>

</ul>
<div class="tab-content" id="SupplierTabContent">
    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab"><?php include './supplier_edit_profile.php'; ?></div>
    <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab"><?php include './supplier_product_overview.php';?></div>
</div>

<?php
include '../common/end.php'
?>