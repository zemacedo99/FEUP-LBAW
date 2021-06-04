@extends('layouts.app')

@section('content')

    <script type="text/javascript" src={{ asset('js/item_details.js') }} defer> </script>

    <div class="container">

        <div class="row mt-5">

            <div class="col-12 col-lg-7" id="mainContainer">

                @if ($is_bundle)
                    @include('partials.bundle',$productsInBundle)

                @else
                     @include('partials.carousel_img',$images)
                @endif
            </div>



            <div class="col-12 col-lg-4 mt-5 mt-lg-0" id="DataContainer">
                <h2>{{ $name }}</h2>
                @if ($stock <= 10)
                    <h6 class="text-muted">Only {{ $stock }} left!</h6>
                @else
                    <h6 class="text-muted">{{ $stock }} left!</h6>
                @endif

                <input type="hidden" id="price" value="{{ $price }}" readonly>

                <input type="hidden" id="item_id" value="{{ $id }}">

                <input type="hidden" id="client_id" value="{{ Auth::id() }}" readonly>


                <br>
                <h4><b>{{ number_format ( $price , 2) }}€@isset($unit)/{{ $unit }} @endisset</b></h4>
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
                        <small class="text-danger" id="quantity_alert"></small>
                        <div class="text-muted" id="total">Total: 0€</div>

                    </div>
                </div>

                @if (((Auth::check() && app('App\Models\Client')::find(Auth::user()->id)!=null)||!Auth::check())&&($active)) {{--if not logged in, or if logged in must be a client--}}
                    @guest <a href="/register"> @endguest <button type="button" id="add_cart" class="btn btn-primary"><i>Buy </i><i class="bi bi-basket"></i></button> @guest</a> @endguest
                @endif
                

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
                        @foreach ($tags as $tag)
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


            @foreach ($reviews as $review)

                <div class="row mt-3 border">
                    <div class="col">
                        <div class="row">
                            <h4> {{ $review->client->name }}
                                @if ($admin == true)
                                    <button class="btn btn-sm d-none d-md-inline" data-bs-toggle="modal"
                                        data-bs-target="#deleteReviewModal" clientId={{ $review->client->id }}
                                        itemId={{ $review->item->id }}><i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </h4>
                        </div>

                        <div class="row">
                            <div class="col-12">

                                @for ($i = 1; $i <= 5; $i++)

                                    @if ($i <= $review->rating) <i class="bi
                                        bi-star-fill"></i>

                                    @else
                                        <i class="bi bi-star"></i> @endif

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


    @if ($admin)
        <script src="{{ asset('js/admin_modal.js') }}" defer></script>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-labelledby="deleteReviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteReviewModalLabel">Confirming product request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure that you want to delete this review?</p>
                    <p id="prod_id" class="fw-bold text-center"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.modals.success_add_cart')

@endsection
