<?php
include_once '../common/extras.php';
pageHeader("MyGarden - Supplier");
navbar();
?>

<div class="row d-flex d-lg-none mb-2 mt-2">
    <div class="col-12 d-flex justify-content-center">
        <div class="position-relative">
            <img src="../images/img_avatar.png" class="rounded-circle img-fluid d-flex justify-content-center" style="width: 150px;"></img>
            <span class="badge rounded-pill bg-primary" style="transform:translate(120px,-40px)"><i class="bi bi-pencil"></i></span>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center mb-2">
        <div class="form-floating">
            <input type="text" class="form-control" id="ClientName" placeholder="Name" value="André Gomes">
            <label for="ClientName">Name</label>
        </div>
    </div>

</div>

<ul class="nav nav-tabs row mb-3 d-lg-none" id="SupplierTab" role="tablist">
    <li class="col-6 nav-item p-0" role="presentation">
        <button class="col-12 nav-link ps-4 active" id="supplierProfile-tab" data-bs-toggle="tab" data-bs-target="#supplierProfile" type="button" role="tab" aria-controls="supplierProfile" aria-selected="true">Profile</button>
    </li>
    <li class="col-6 nav-item p-0" role="presentation">
        <button class="col-12 nav-link pe-4" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-controls="products" aria-selected="false">Products</button>
    </li>
</ul>

<div class="tab-content" id="SupplierTabContent">
    <div class="tab-pane fade col-lg-6 show active" id="supplierProfile" role="tabpanel" aria-labelledby="supplierProfile-tab"><?php include './supplier_inc_edit_profile.php'; ?></div>
    <div class="tab-pane fade col-lg-6" id="products" role="tabpanel" aria-labelledby="products-tab"><?php include './supplier_inc_product_overview.php'; ?></div>
</div>

<?php
footer();
?>