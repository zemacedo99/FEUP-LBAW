<div class="card mb-3">
    <div class="row g-0">
        <div class="col-4 col-md-3 col-lg-2">
            <img src="{{ asset( $item->image) }}" alt="...">
        </div>
        <div class="col-8 col-md-9 col-lg-10">
            <div class="card-body">
                <div class="d-flex justify-content-between justify-content-md-start">
                    <h4 class="card-title text-truncate">{{ $item->name }}</h4>
                    <i class="bi bi-cart-plus ps-md-4"></i>
                </div>
                <h6 class="card-subtitle text-muted">{{ $item->price }}€/{{ $item->unit }}</h6>

                <div class="row row-cols-1 row-cols-md-2">
                    <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9"> {{ $item->description }} </p>
                    <h4 class="card-title text-end text-md-start order-md-3">{{ $item->getOriginal('pivot_price') }}€</h4>
                    <div class="text-center order-md-2 col-md-3 col-lg-3 overdiv">
                        @switch($type)
                            @case('cancel')
                            <button type="button" class="btn btn-secondary text-truncate" data-bs-toggle="modal"
                                    data-bs-target="#modalCancelOrder"><i class="bi bi-x"></i> Cancel Order</button>
                            @break
                            @case('edit')
                            <button type="button" class="btn btn-primary text-truncate" data-bs-toggle="modal"
                                    data-bs-target="#modalReview"><i class="bi bi-list"></i> Edit Review</button>
                            @break
                            @case('leave')
                            <button type="button" class="btn btn-success text-truncate"><i
                                    class="bi bi-plus"></i> Leave a Review</button>
                            @break
                            @default
                            <p>There was an error, our monkeys are working to fix it</p>
                        @endswitch
                    </div>
                </div>
                <a href="{{ url("/item/$item->id") }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
</div>
