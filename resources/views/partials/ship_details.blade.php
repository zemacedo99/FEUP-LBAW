<input type="hidden" name="sd_id" id="sd_id">

<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
    <div class="row mt-3"></div>
    <div class="row mt-3"></div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 style='text-align:left;border-bottom:2px solid black;'>Shipping Address</h3>
            </div>
        </div>
    </div>
    <div class="row mt-3"></div>
    <div class="row mt-3"></div>
    <div class="row mt-3"></div>


    <div class="row mb-3">
        <div class="col">
            <div class="form-floating">
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="FirstName" value=@isset($sd) {{$sd->first_name}} @endisset>
                <label for="first_name">First Name</label>
            </div>
            <small id="first_name_alert" class="text-danger"></small>
        </div>
        <div class="col">
            <div class="form-floating">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="LastName" value=@isset($sd) {{$sd->last_name}} @endisset>
                <label for="last_name">Last Name</label>
            </div>
            <small id="last_name_alert" class="text-danger"></small>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-8">
            <div class="form-floating">
                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value=@isset($sd) {{$sd->address}} @endisset>
                <label for="address">Address</label>
            </div>
            <small id="address_alert" class="text-danger"></small>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="door_n" name="door_n" placeholder="Door N" value=@isset($sd) {{$sd->door_n}} @endisset>
                <label for="door">Door Nº</label>
            </div>
            <small id="door_n_alert" class="text-danger"></small>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="post_code" name="post_code" placeholder="Zip Code" value=@isset($sd) {{$sd->post_code}} @endisset>
                <label for="zip_code">Zip Code</label>
            </div>
            <small id="post_code_alert" class="text-danger"></small>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="district" name="district" placeholder="District" value=@isset($sd) {{$sd->district}} @endisset>
                <label for="district">District</label>
            </div>
            <small id="district_alert" class="text-danger"></small>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="city" name="city" placeholder="City" value=@isset($sd) {{$sd->city}} @endisset>
                <label for="city">City</label>
            </div>
            <small id="city_alert" class="text-danger"></small>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="form-floating">
                <input type="text" class="form-control" id="country" name="country" placeholder="Country" value=@isset($sd) {{$sd->country}} @endisset>
                <label for="country">Country</label>
            </div>
            <small id="country_alert" class="text-danger"></small>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="form-floating">
                <input type="text" class="form-control" id="phone_n" name="phone_n" placeholder="Phone Number" value=@isset($sd) {{$sd->phone_n}} @endisset>
                <label for="phone">Phone Number</label>
            </div>
            <small id="phone_n_alert" class="text-danger"></small>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                <div class="form-check form-switch">
                    <label class="form-check-label" for="save_ship_info">Save data for future purchases</label>
                    <input class="form-check-input" type="checkbox" id="save_ship_info" name="save_ship_info" checked>
                </div>
            </div>
        </div>
    </div>

</div>