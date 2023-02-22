@isset($images)
    <div id="mainContainer" class="col-12 col-lg-6 mb-5 mb-lg-0 " >
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-indicators">
                @php
                    $count = 0;
                @endphp
                @foreach ($images as $image)
                
                    @if ($count == 0)
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$count}}" class="active" aria-current="true" aria-label="Slide {{$count}}"></button>
                    @else
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$count}}" aria-label="Slide {{$count}}"></button>
                    @endif

                    @php
                        $count++;
                    @endphp
                
                @endforeach
            </div>
            <div class="carousel-inner" style=" width:100%; max-height: 400px !important;">


                @php
                    $count = 0;
                @endphp
                @foreach ($images as $image)
                    @if ($count == 0)
                        <div class="carousel-item active" style="height: 275px; max-height: 275px;">
                            <img src="{{ asset($image->path) }}" class="d-block w-100" alt="product image" style="height:100%; width:100%">
                        </div>
                    @else
                        <div class="carousel-item " style="height: 275px; max-height: 275px;">
                            <img src="{{ asset($image->path) }}" class="d-block w-100" alt="product image" style="height:100%; width:100%">
                        </div>
                    @endif

                    @php
                        $count++;
                    @endphp
                
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
@endisset
