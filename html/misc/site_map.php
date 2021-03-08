<?php
include '../common/head.php';
include '../common/navbar.php';
?>

<div class="container">
    <h3 class="mt-3 mb-3">Site Map</h3>

    <div class="row">
        <div class="list-group col-3 mb-3">
            <a href="../client/client_profile.php" class="list-group-item list-group-item-action fw-bold">Client</a>
            <a href="../client/client_profile.php" class="list-group-item list-group-item-action">Client - Profile</a>

            <a href="../supplier/supplier_profile.php" class="list-group-item list-group-item-action fw-bold">Supplier</a>
            <a href="../supplier/supplier_profile.php" class="list-group-item list-group-item-action">Supplier - Profile</a>
            <a href="../supplier/all_products.php" class="list-group-item list-group-item-action">Supplier - All Products</a>
            <a href="../supplier/createProduct.php" class="list-group-item list-group-item-action">Supplier - Create Product</a>
            <a href="../supplier/bundles_and_cupons.php" class="list-group-item list-group-item-action">Supplier - Bundles and Coupons</a>
            <a href="../supplier/createEditBundle.php" class="list-group-item list-group-item-action">Supplier - Create/Edit Bundle</a>
            <a href="../supplier/createEditCoupon.php" class="list-group-item list-group-item-action">Supplier - Create/Edit Coupon</a>

            <a href="../admin/dashboard.php" class="list-group-item list-group-item-action fw-bold">Admin</a>
            <a href="../admin/view_prods.php" class="list-group-item list-group-item-action">Admin - Products</a>
            <a href="../admin/view_req.php" class="list-group-item list-group-item-action">Admin - Supplier Requests</a>
            <a href="../admin/view_users.php" class="list-group-item list-group-item-action">Admin - Users</a>

            <a href="../checkout/cart_information.php" class="list-group-item list-group-item-action fw-bold">CheckOut</a>
            <a href="../checkout/shipping_payment.php" class="list-group-item list-group-item-action">CheckOut - Payment</a>

            <a href="../credentials/register.php" class="list-group-item list-group-item-action fw-bold">Credentials</a>
            <a href="../credentials/login.php" class="list-group-item list-group-item-action">Credentials - Login</a>
            <a href="../credentials/register.php" class="list-group-item list-group-item-action">Credentials - Register</a>
            
            <a href="../misc/home_page.php" class="list-group-item list-group-item-action fw-bold">HomePage</a>
            <a href="../misc/about_us.php" class="list-group-item list-group-item-action">About Us</a>
            <a href="../misc/productList.php" class="list-group-item list-group-item-action">Product List</a>
            <a href="../misc/productDetail.php" class="list-group-item list-group-item-action">Product Detail</a>
            <a href="../misc/supplierDetail.php" class="list-group-item list-group-item-action">Supplier Detail</a>

        </div>
    </div>

</div>


<?php include '../common/end.php' ?>