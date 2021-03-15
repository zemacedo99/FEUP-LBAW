<?php
addModal(
    "DeleteAccount",
    "Confirmation",
    "Are you sure you want to delete your account? You will lose all of your data, including your purchase History, Favorites and current Periodic Buys.",
    "Delete",
    "Cancel"
);
?>

<div class="modal fade" id="editCard" tabindex="-1" aria-labelledby="editCardLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCardLabel">Edit Card Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="floatingInput" placeholder="**** **** **** ****">
                        <label for="floatingInput">Card number</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="month" class="form-control" id="floatingFirstName" placeholder="Valid until">
                            <label for="floatingFirstName">Valid until</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="floatingLastName" placeholder="CVV">
                            <label for="floatingLastName">CVV</label>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="floatingInput" placeholder="Your name and surname">
                        <label for="floatingInput">Card holder</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCard" tabindex="-1" aria-labelledby="addCardLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCardLabel">Add Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="floatingInput" placeholder="**** **** **** ****">
                        <label for="floatingInput">Card number</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="month" class="form-control" id="floatingFirstName" placeholder="Valid until">
                            <label for="floatingFirstName">Valid until</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="floatingLastName" placeholder="CVV">
                            <label for="floatingLastName">CVV</label>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="floatingInput" placeholder="Your name and surname">
                        <label for="floatingInput">Card holder</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Card</button>
            </div>
        </div>
    </div>
</div>

<div class="row ">
    <div class="col-12 col-lg-5">
        <div class="col-12 mb-4">
            <h3>Personal Info</h3>
        </div>
        <div class="row row-cols-1 row-cols-lg-2 d-flex justify-content-center mb-3">
            <div class="col" style="width: 150px;">
                <img src="../images/img_avatar.png" class="rounded-circle img-fluid">
            </div>
            <div class="col mt-2 d-flex align-items-center justify-content-center justify-content-lg-start">
                <div class="form-floating">
                    <input type="text" class="form-control" id="ClientName" placeholder="Name" value="André Gomes">
                    <label for="ClientName">Name</label>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="up201806224@fe.up.pt">
                <label for="floatingInput">Email address</label>
            </div>
        </div>
        <div class="col-12 mb-5">
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" value="olátudobem?">
                <label for="floatingPassword">Password</label>
            </div>
        </div>

        <div class="col-12 col-lg-12 d-flex justify-content-center mb-4">
            <label class="btn btn-primary" for="sup_img">
                Profile Pic
            </label>
            <input type="file" class="form-control d-none" id="sup_img" aria-describedby="sup_img_addon" aria-label="Upload">
        </div>
    </div>

    <div class="col d-none d-lg-block col-lg-1"></div>

    <div class="col-12 col-lg-6">
        <div class="col-12 mb-4">
            <h3>Shipping Details</h3>
        </div>

        <div class="row mb-3">
            <div class="col">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingFirstName" placeholder="FirstName">
                    <label for="floatingFirstName">First Name</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingLastName" placeholder="LastName">
                    <label for="floatingLastName">Last Name</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-8">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingAddress" placeholder="FirstName">
                    <label for="floatingAddress">Address</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingDoor" placeholder="LastName">
                    <label for="floatingDoor">Door Nº</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingZipcode" placeholder="FirstName">
                    <label for="floatingZipcode">Zip Code</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingDistrict" placeholder="LastName">
                    <label for="floatingDistrict">District</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingCity" placeholder="LastName">
                    <label for="floatingCity">City</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingCountry" placeholder="FirstName">
                    <label for="floatingCountry">Country</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingPhone" placeholder="FirstName">
                    <label for="floatingPhone">Phone Number</label>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h3 class="mb-3">Payment Information</h3>

            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-2 col-md-2">
                        <img src="https://via.placeholder.com/80x80" alt="...">
                    </div>
                    <div class="col-8 col-md-9">
                        <div class="card-body">
                            <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard"></a>
                            <h6 class="card-title">Card Holder</h6>
                            <p class="card-text">Visa car Ending in **69</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3 d-flex justify-content-center align-items-center" style="height: 80px;">
                <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#addCard"></a>
                <p class="card-text">Add new Card <i class="bi bi-plus"></i></p>
            </div>

        </div>


    </div>

    <div class="col-12 col-lg-6 d-flex justify-content-center mb-4">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteAccount"><i class="bi bi-trash"></i> Delete Account</button>
    </div>

</div>