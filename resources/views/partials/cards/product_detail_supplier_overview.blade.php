<div class="card mb-3 " >
    <div class="row g-0">
        <div class="col-3 col-md-2 col-lg-3 col-xl-2">
            @isset($images[0])
                <img src="{{ asset($images[0]->path) }}" alt="{{$name}}" style="margin-left:auto; margin-right:auto;width:8em;height:8em;">
                <input type="hidden" class="imgProd" value="{{ asset($images[0]->path) }}" disabled>
            @endisset
            
        </div>
        <div class="col-9 col-md-10 col-lg-9 col-xl-10">
            <div class="card-body">
                <div class="d-flex justify-content-between justify-content-md-start">
                    <h4 class="card-title" >{{$name}}</h4>
                    <input type="hidden" class="name" value="{{$name}}" disabled>
                </div>
                <input type="hidden" class="price"  value="{{$price}}" disabled>
                <h6 class="card-subtitle text-muted">{{$price}}€@isset($unit)/{{$unit}}@endisset</h6>

                <div class="row row-cols-1 row-cols-md-2">
                    <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9" class="description">
                        {{$description}}
                    </p>
                </div>
                <div class="row">
                    <div class="col"></div>

                    <div class="col-3">
                        @isset($add)
                            <button class="btn btn-primary prod_ovrw">Add</button>
                        @endisset    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>