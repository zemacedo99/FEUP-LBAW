<div class="card mb-3">
    <div class="row g-0">
        <div class="col-4 col-md-3 col-lg-2" style="max-height:160px; max-width:160px;">
            <img src="{{ asset( $item->image) }}" alt="Product image" style="height:100%; width:100%">
        </div>
        <div class="col-8 col-md-9 col-lg-10">
            <div class="card-body">
                <div class="d-flex justify-content-between justify-content-md-start">
                    <h4 class="card-title text-truncate">{{ $item->name }}</h4>
                </div>
                <h6 class="card-subtitle text-muted">{{ $item->price }}€/{{ $item->unit }}</h6>

                <div class="row row-cols-1 row-cols-md-2">
                    <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9"> {{ $item->description }} </p>
                    <h4 class="card-title text-end text-md-start order-md-3">{{ $item->getOriginal('pivot_price') }}€</h4>
                    <div class="text-center order-md-2 col-md-3 col-lg-3 overdiv">
                        @switch($item->status)
                            @case('InProgress')
                            <button type="button" class="btn btn-secondary text-truncate" data-bs-toggle="modal" data-bs-whatever="{{$item->id}}"
                                    data-bs-target="#modalCancelOrder"><i class="bi bi-x"></i> Cancel Order</button>
                            @break
                            @case('Paid')
                            <button type="button" class="btn btn-success text-truncate" data-bs-toggle="modal" data-bs-whatever="{{$item->id}}"
                                data-bs-product_name="{{$item->name}}"  data-bs-target="#modalReview"><i class="bi bi-plus"></i> Leave/Edit a Review</button>
                            @break
                            @case('Canceled')
                            <button disabled type="button" class="btn btn-secondary text-truncate">
                                                            Canceled</button>
                            @break
                            @default
                            <p>There was an error, our monkeys are working to fix it</p>
                        @endswitch
                    </div>
                </div>
                <a href="{{ url("/items/$item->id") }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
</div>
