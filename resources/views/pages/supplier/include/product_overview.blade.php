<div class="container-sm">
    <div class="row d-flex justify-content-center d-none d-lg-flex mt-3 fs-3 mb-5">Products</div>

    <div class="row mb-5 mt-2">
        <div class="col-5 d-flex justify-content-center">
            <a href="{{ route('create_product'  , ['id' => \Illuminate\Support\Facades\Auth::id()]) }}"><button type="button" class="btn btn-primary"><i class="bi bi-plus"></i> Add a Product</button></a>
        </div>
        <div class="col-7 d-flex justify-content-center">
            <a href="{{ route('supplier_bundles_and_coupons'  , ['id' => \Illuminate\Support\Facades\Auth::id()]) }}"><button type="button" class="btn btn-primary"> <i class="bi bi-bag-fill"></i> Bundles and <i class="bi bi-cash"></i> Cupons <i class="bi bi-caret-right"></i></button></a>
        </div>
    </div>



    @php
        $max = 4;
    @endphp


    @foreach ($items as $item)
        
        @php
            $data = 
            [
                'name' => $item[0]->name,
                'price' => $item[0]->price,
                'description' => $item[0]->description,
                'unit' => $item[1],
                'images' => $item[2],
            ];
        @endphp
        @include('partials.cards.product_detail_supplier_overview',$data)

        @php
            if($max == 1)
            {
                break;
            }

            $max--;
        @endphp
        

    @endforeach

    <div class="row">
        <a href="{{ route('supplier_all_products'  , ['id' => \Illuminate\Support\Facades\Auth::id()]) }}" class="link-dark">See all Products</a>
    </div>

</div>