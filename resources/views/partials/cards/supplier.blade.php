<a href="/suppliers/{{$id}}" id="unformatedLink">
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
            <img class="img-fluid" src="{{ asset($image->path) }}" alt="...">
        </div>
        <div class="col-8 col-md-9 col-lg-10">
            <div class="card-body">
                <div class="d-flex justify-content-between ">
                    <h4 class="card-title">{{ $name }}</h4>
                </div>
                <div class="row row-cols-md-2">
                    <div class="col-10">
                        <h5 class="card-title ">{{ $address}}</h5>
                        
                        {{-- <div class="rating justify-content-end"> 
                            
                        
                        </div> --}}
                    </div>
                </div>

                <div class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9">{{ $description }}</div>
            </div>
        </div>
    </div>
</div>
</a>