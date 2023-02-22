<div class="card mb-3">
    <div class="row g-0">
        <div class="col-4 col-md-3 col-lg-2 col-xl-2" style="max-height:160px; max-width:160px;">
            <img src="{{ asset( $item->image) }}" alt="Product image" style="height:100%; width:100%">
        </div>
        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-2">
                    <div class="col col-md-9 ">
                        <div class="row d-flex align-content-around flex-wrap">
                            <div class="col col-12 col-md-6 order-md-1">
                                <h5 class="card-title">{{ $item->name }}</h5>
                            </div>
                            <div class="col col-6  col-md-12 order-md-3">
                                <h6 class="card-subtitle text-muted">{{ $item->price }}€/{{ $item->unit }}</h6>
                            </div>
                            <div class="col text-truncate d-none d-md-block col-md-12 order-md-4 ">{{ $item->description }}</div>
                            <div class="col coo-12 order-md-5">
                                <h4 class="card-title text-end text-md-start order-md-3">{{ $item->getOriginal('pivot_price') }}€</h4>
                            </div>
                            <div class="col coo-12 col-md-6 order-md-2">
                                <h6 class="card-title text-center text-md-end">{{ $item->purchase_type }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Tem de se mudar o Sass para que a class btn-group-vertical possa ser ativada com breakpoints https://stackoverflow.com/questions/46808709/bootstrap-4-responsive-wrapping-button-group -->
                    <div class="col col-md-3 d-flex justify-content-center align-items-center overdiv">
                        <div class="btn-group d-inline-flex d-md-none" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#periodicEdit"><i class=" bi bi-list"></i> Edit Periodic Buy</button>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalDeletePeriodic"><i class="bi bi-trash"></i> Cancel</button>
                        </div>
                        <div class="btn-group-vertical d-none d-md-inline-flex" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#periodicEdit"><i class="bi bi-list"></i> Edit Periodic Buy</button>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalDeletePeriodic"><i class="bi bi-trash"></i> Cancel</button>
                        </div>
                    </div>
                </div>
                <a href="{{ url("/item/$item->id") }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
</div>
