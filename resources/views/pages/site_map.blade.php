@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mt-3 mb-3">Site Map</h3>

        <div class="row">
            <div class="list-group col col-md-6 col-lg-3 mb-3">
                <a href="../client/client_profile.php" class="list-group-item list-group-item-action fw-bold">Client</a>
                <a href="../client/client_profile.php" class="list-group-item list-group-item-action">Client -
                    Profile</a>

                <a href="../supplier/detail.php" class="list-group-item list-group-item-action fw-bold">Supplier</a>
                <a href="../supplier/supplier_profile.php" class="list-group-item list-group-item-action">Supplier -
                    Profile</a>
                <a href="../supplier/all_products.php" class="list-group-item list-group-item-action">Supplier - All
                    Products</a>
                <a href="../supplier/create_product.php" class="list-group-item list-group-item-action">Supplier -
                    Create Product</a>
                <a href="../supplier/bundles_and_cupons.php" class="list-group-item list-group-item-action">Supplier -
                    Bundles and Coupons</a>
                <a href="../supplier/create_edit_bundle.php" class="list-group-item list-group-item-action">Supplier -
                    Create/Edit Bundle</a>
                <a href="../supplier/create_edit_coupon.php" class="list-group-item list-group-item-action">Supplier -
                    Create/Edit Coupon</a>

                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action fw-bold">Admin</a>
                <a href="{{ route('admin_products') }}" class="list-group-item list-group-item-action">Admin - Products</a>
                <a href="{{ route('admin_requests') }}" class="list-group-item list-group-item-action">Admin - Supplier
                    Requests</a>
                <a href="{{ route('admin_users') }}" class="list-group-item list-group-item-action">Admin - Users</a>

                <a href="../checkout/cart_info.php" class="list-group-item list-group-item-action fw-bold">CheckOut</a>
                <a href="../checkout/shipping_payment.php" class="list-group-item list-group-item-action">CheckOut -
                    Payment</a>

                <a href="../credentials/register.php"
                   class="list-group-item list-group-item-action fw-bold">Credentials</a>
                <a href="../credentials/login.php" class="list-group-item list-group-item-action" data-bs-toggle="modal"
                   data-bs-target="#loginModal">Credentials - Login</a>
                <a href="../credentials/register.php" class="list-group-item list-group-item-action">Credentials -
                    Register</a>

                <a href="../misc/home_page.php" class="list-group-item list-group-item-action fw-bold">HomePage</a>
                <a href="../misc/about_us.php" class="list-group-item list-group-item-action">About Us</a>
                <a href="../misc/products_list.php" class="list-group-item list-group-item-action">Product List</a>
                <a href="../misc/product_detail.php" class="list-group-item list-group-item-action">Product Detail</a>
                <a href="../supplier/detail.php" class="list-group-item list-group-item-action">Supplier Detail</a>
            </div>
        </div>

    </div>
@endsection
