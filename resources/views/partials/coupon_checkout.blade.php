<div class="col-12  col-lg-12 order-3">
    <input type="hidden" id="all_coupons" name="all_coupons" value= "">
    <div class="row">

        <div class="col"></div>

        <div class="col-12 col-lg-12">

            <div class="row">
                <h3 style='text-align:left;border-bottom:2px solid black;'>Coupons <button type="button" class="simpleicon" >redeem</button></h3>
            </div>

            <div class="row mt-3"></div>

            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="CODE" id="coupon_code">
                    <small id="coupon_alert" class="text-danger"></small>
                </div>
                <div class="col-3 text-center">
                    <button type="button" class="simpleicon" id="addCoupon">add</button>
                </div>
            </div>

            <div class="row mt-3"></div>

            <div class="row row-cols-1 row-cols-md-2 g-4" id="coupons_list">
                {{-- @include('partials.cards.coupon')
                @include('partials.cards.coupon') --}}
            </div>

            <div class="row m-3"></div>

        </div>
        <div class="col"></div>

        <div class="row m-3"></div>
    </div>
</div>