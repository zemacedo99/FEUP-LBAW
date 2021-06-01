<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mx-auto">

    <div class="card h-100" style="width: 540px; height: 200px; max-width: 540px;">
        <div class="row g-0">

            <div class="col-md-4">
                @isset($images[0])
                <img src="{{ asset($images[0]->path) }}" class="card-img-top" alt= {{$name}} style="margin-left:auto; margin-right:auto;width:8em;height:8em;">
                @endisset
            </div>
            <div class="col-md-8">
            <div class="product-grid8">

                    <div class="card-body">
                        <h5 class="card-title">{{$name}}</h5>
                        <p class="card-text"><small class="text-muted">{{$price}}€@isset($unit)/{{$unit}}@endisset</small></p>
                        <p class="card-text">{{$description}}</p>
                    </div>
                    
                    <ul class="social">
                        <li><a href="{{ route('item_detail', ['id' => $id])}}" data-tip="View"><i class="bi bi-eye"></i></a></li>
                        @if ($is_bundle)
                            
                        @else
                            <li><a href="{{ route('edit_product', ['id' => $id])}}" data-tip="Edit"><i class="bi bi-pencil"></i></a></li>
                        @endif
                            
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>