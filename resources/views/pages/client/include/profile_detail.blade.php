{{-- Delete Account Modal --}}
<div class="modal fade" id="modalDeleteAccount" tabindex="-1" aria-labelledby="modalDeleteAccountLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteAccountLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete your account? You will lose all of your data, including your purchase History, Favorites and current Periodic Buys.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('client.delete', ['client' => $client->id]) }}" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-primary">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Edit CC Modal --}}
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
                        <input class="form-control" id="editCCNumber" placeholder="**** **** **** ****">
                        <label for="editCCNumber">Card number</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="month" class="form-control" id="editCCDate">
                            <label for="editCCDate">Valid until</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="editCCCvv" placeholder="CVV">
                            <label for="editCCCvv">CVV</label>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="editCCName" placeholder="Your name and surname">
                        <label for="editCCName">Card holder</label>
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
{{-- Add CC Modal --}}
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
                        <input class="form-control" id="addCCNumber" placeholder="**** **** **** ****">
                        <label for="addCCNumber">Card number</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="month" class="form-control" id="addCCDate" >
                            <label for="addCCDate">Valid until</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="addCCCvv" placeholder="CVV">
                            <label for="addCCCvv">CVV</label>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="addCCName" placeholder="Your name and surname">
                        <label for="addCCName">Card holder</label>
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
                <img src="{{ asset($client->image->path) }}" class="rounded-circle img-fluid" alt="Profile Picture">
            </div>
            <div class="col mt-2 d-flex align-items-center justify-content-center justify-content-lg-start">
                <div class="form-floating">
                    <input type="text" class="form-control" id="ClientName" placeholder="Name" value="{{ $client->name }}" data-id="{{ $client->id }}">
                    <label for="ClientName">Name</label>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="clientEmail" placeholder="name@example.com" value="{{ $client->user()->email }}">
                <label for="clientEmail">Email address</label>
            </div>
        </div>
        <div class="col-12 mb-5">
            <div class="form-floating">
                <input type="password" class="form-control" id="clientPassword" placeholder="Password" value="">
                <label for="clientPassword">Password</label>
            </div>
        </div>

        <div class="col-12 col-lg-12 d-flex justify-content-center mb-4">
            <label class="btn btn-primary" for="sup_img">
                Profile Pic
            </label>
            <input type="file" class="form-control d-none" id="sup_img" aria-label="Upload">
        </div>
        <div class="col-12 col-lg-12 d-flex justify-content-around mb-4">
            <div class="row-6 d-flex justify-content-center">
                <label class="btn btn-primary" for="update_data">
                    Update Profile Info
                </label>
                <button  class="btn btn-primary form-control d-none" id="update_data"></button>
            </div>
            <div class="row-6 d-flex justify-content-center">
                <label class="btn btn-primary" for="update_shipping">
                    Update Shipping Details
                </label>
                <button  class="btn btn-primary form-control d-none" id="update_shipping"></button>
            </div>

        </div>

        <div id="error-message" class="alert alert-danger" hidden>
            <ul>
                <li></li>
            </ul>
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
                    <input type="text" class="form-control" id="floatingFirstName" placeholder="FirstName" value="{{ $client->ship_detail->first_name }}">
                    <label for="floatingFirstName">First Name</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingLastName" placeholder="LastName" value="{{ $client->ship_detail->last_name }}">
                    <label for="floatingLastName">Last Name</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-8">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingAddress" placeholder="Address" value="{{ $client->ship_detail->address }}">
                    <label for="floatingAddress">Address</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingDoor" placeholder="Door Nº" value="{{ $client->ship_detail->door_n }}">
                    <label for="floatingDoor">Door Nº</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingZipcode" placeholder="Zip Code" value="{{ $client->ship_detail->post_code }}">
                    <label for="floatingZipcode">Zip Code</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingDistrict" placeholder="District" value="{{ $client->ship_detail->district }}">
                    <label for="floatingDistrict">District</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingCity" placeholder="City" value="{{ $client->ship_detail->city }}">
                    <label for="floatingCity">City</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingCountry" placeholder="Country" value="{{ $client->ship_detail->country }}">
                    <label for="floatingCountry">Country</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingPhone" placeholder="Phone Number" value="{{ $client->ship_detail->phone_n }}">
                    <label for="floatingPhone">Phone Number</label>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h3 class="mb-3">Payment Information</h3>

            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-2 col-md-2" style="max-height:83px; max-width:83px;">
                        <img src="{{ asset('images/VISA-logo-square.png') }}" alt="..." style="height:100%; width:100%">
                    </div>
                    <div class="col-8 col-md-9">
                        <div class="card-body">
                            <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard"></a>
                            <h6 class="card-title">Card Holder</h6>
                            <p class="card-text">Visa card Ending in **69</p>
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
