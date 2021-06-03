<div class="row m-3"></div>

<div class="col-12" style='border:1px solid silver;'>
    <div class="bundle_products_box">
        <div class="row">

            @foreach ($productsInBundle as $product)
            <div class="col-6">
                @include('partials.cards.product_in_bundle_detail')
            </div>
                
            @endforeach

        </div>
    </div>

</div>

