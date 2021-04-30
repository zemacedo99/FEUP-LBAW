@extends('layouts.app')

@section('content')

<script type="text/javascript" src={{ asset('js/item_details.js') }} defer> </script>

<div class="container">

    <div class="row mt-5">

        <div class="col-12 col-lg-7" id="mainContainer">

        @if ($is_bundle)
            @include('partials.bundle')
        
        @else

                <div id="carrouselContainer" class="container-fluid">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel"
                        data-bs-interval="false">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner" style=" width:100%; max-height: 450px !important;">

                            @isset($images)
                            
                                @foreach($images as $image)
                                    <div class="carousel-item">
                                        <img src="{{ url('storage/public/images/'.$image) }}"  class="d-block w-100" alt="" title="" />  

                                        {{-- <img src="{{ $path }}" class="d-block w-100" alt="..."> --}}
                                    </div>
                                @endforeach
                            @endisset

                            <div class="carousel-item active">
                                <img src="https://www.infoescola.com/wp-content/uploads/2010/11/ma%C3%A7a-verde_312027470.jpg"
                                    class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="../images/apples.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="https://www.portaldojardim.com/pdj/wp-content/uploads/Ma%C3%A7as-verdes.jpg"
                                    class="d-block w-100" alt="...">
                            </div>
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
                @endif
            </div>



        <div class="col-12 col-lg-4 mt-5 mt-lg-0" id="DataContainer">
            <h2>{{ $name }}</h2>
            @if ($stock <= 10)
                <h6 class="text-muted">Only {{ $stock }} left!</h6>
            @else
                <h6 class="text-muted">{{ $stock }} left!</h6>
            @endif
            
            <input type="hidden" id="price"  value="{{ $price}}">
            
            <br>
            <h4><b>{{ $price}}€@isset($unit)/{{ $unit }} @endisset</b></h4>
            <br>
           

       

            <div class="col-6 mb-2">
                <div class="form">
                    <label class="form-label" for="quantity">Quantity</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="quantity" min="0">
                        @isset($unit)
                        <span class="input-group-text">{{ $unit }} </span>
                        @endisset
                    </div>
                    <div class="text-muted" id="total" >Total: 0€</div>

                </div>
            </div>

            <button type="button" class="btn btn-primary"><i>Buy </i><i class="bi bi-basket"></i></button>

        </div>
    </div>

    <!-- Description and Tags -->
    <div class="row mt-5">
        <h4>Description</h4>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-7">
            <p class="border px-1">
                {{ $description }}
            </p>

        </div>




        <div class="col-6 col-lg-5" style="min-height: 100px;">
            <div class="d-grid gap-2 d-lg-block  ">
                @isset($tags)
                    @foreach($tags as $tag)
                        <button class="btn btn-secondary btn-sm">{{ $tag->value }}</button>
                    @endforeach
                @endisset

                {{-- <button class="btn btn-secondary btn-sm">Organic</button>

                <button class="btn btn-secondary btn-sm">Food</button>

                <button class="btn btn-secondary btn-sm">Fresh</button>

                <button class="btn btn-secondary btn-sm">Vegetable</button> --}}
            </div>

        </div>
    </div>

    @isset($reviews) 
        <div class="row mt-4">
            <h3>What other costumers say:</h3>
        </div>

    
        @foreach($reviews as $review)

            <div class="row mt-3 border">
                <div class="col">
                    <div class="row">
                        <h4> {{ $review->client->name }} </h4>
                    </div>
        
                    <div class="row">
                        <div class="col-12">

                            @for ($i = 0; $i < 5; $i++)

                                @if ($i <=  $review->rating )
                                    <i class="bi bi-star-fill"></i>

                                @else
                                    <i class="bi bi-star"></i>
                                @endif
                                
                            @endfor
                            
                        </div>

                        <div class="col"></div>


                    </div>
        
                    <div class="row">
                        <div class="text-muted"> {{ $review->description }}</div>
                    </div>
        
                </div>
            </div>
        
            
        @endforeach
    @endisset



</div>


@endsection
