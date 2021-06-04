<div class="modal fade" id="modalSupplierProducts" tabindex="-1" aria-labelledby="modalSupplierProducts" aria-hidden="true">
    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSupplierProductsLabel">My Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                @foreach ($products as $product)

                    @php
                    $data = 
                    [
                        'name' => $product->name,
                        'price' => $product->price,
                        'description' => $product->description,
                        'unit' => $product->unit,
                        'images' => $product->images,
                        'add' => true    
                    ];
                    

                    @endphp
                    {{-- todo: find a way to select the card and get the value  --}}
                    @include('partials.cards.product_detail_supplier_overview',$data)
    
                    
                @endforeach
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>
