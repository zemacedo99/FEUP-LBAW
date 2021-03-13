<?php
addModal(
    "DeleteSupplierAccount",
    "Confirmation",
    "Are you sure you want to delete your Store account? You will lose all of your data, including control off your products, Cupons and Bundles.",
    "Delete",
    "Cancel"
);
?>

<div class="container-sm col-sm-10">

    <div class="col d-flex justify-content-center d-none d-lg-flex mt-3 fs-3">Profile</div>

    <div class="col-12 d-none d-lg-block mt-0">
        <div class="row row-cols-2 d-flex justify-content-center align-items-center" style="height: 150px;">
            <div class="col col-sm-1" style="width: 100px;">
                <img src="../images/img_avatar.png" class="rounded-circle img-fluid">
            </div>
            <div class="col fs-5">
                <div class="form-floating">
                    <input type="text" class="form-control" id="ClientName" placeholder="Name" value="André Gomes">
                    <label for="ClientName">Name</label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email</label>
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
    </div>

    <div class="col-12 mb-3">
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave your description here" id="floatingDescription" style="height: 100px"></textarea>
            <label for="floatingDescription">Description</label>
        </div>
    </div>

    <div class="col-12 mb-3">
        <div class="form-floating">
            <input type="text" class="form-control" id="floatingAddress" placeholder="Address">
            <label for="floatingAddress">Address</label>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingPostCode" placeholder="floatingPostCode">
                <label for="floatingPostCode">Post Code</label>
            </div>
        </div>
        <div class="col-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingCity" placeholder="City">
                <label for="floatingCity">City</label>
            </div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <div class="form-floating">
            <input type="text" class="form-control" id="floatingNIF" placeholder="NIF">
            <label for="floatingNIF">NIF</label>
        </div>
    </div>

    <div class="col-12 col-lg-12 d-flex justify-content-center mb-4">
        <label class="btn btn-primary" for="sup_img">
            Profile Pic
        </label>
        <input type="file" class="form-control d-none" id="sup_img" aria-describedby="sup_img_addon" aria-label="Upload">
    </div>

    <div class="col-12 col-lg-12 d-flex justify-content-center mb-4">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteSupplierAccount"><i class="bi bi-trash"></i> Delete Account</button>
    </div>

</div>