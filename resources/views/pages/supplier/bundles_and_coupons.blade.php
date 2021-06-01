@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row m-4"></div>

        <div class="row mb-3">

            <a href="{{ route('supplierProfile', ['id' => \Illuminate\Support\Facades\Auth::id()]) }}" class="link-dark"
                style='text-align:left;'>Back to profile</a>
            <div class="row m-1"></div>

            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">

                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="bundles-tab" data-bs-toggle="tab" data-bs-target="#bundles"
                        type="button" role="tab" aria-controls="bundles" aria-selected="true">Bundles</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cupons-tab" data-bs-toggle="tab" data-bs-target="#cupons" type="button"
                        role="tab" aria-controls="cupons" aria-selected="false">Cupons</button>
                </li>


            </ul>


            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="bundles" role="tabpanel" aria-labelledby="bundles-tab">

                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>


                    <div class="row">
                        <div class="col"></div>
                        <div class="col-8">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('create_bundle', ['id' => \Illuminate\Support\Facades\Auth::id()]) }}">
                                <button type="button" class="btn btn-primary"> Add Bundle</button>
                                </a>
                            </div>

                            <div class="row mt-3"></div>
                            <div class="row mt-3"></div>

                            <div class="row row-cols-1 row-cols-md-2 g-4">

                                @foreach ($bundles as $bundle)


                                    @php
                                        $bundle_data = [
                                            'id'  => $bundle->id,
                                            'name' => $bundle->name,
                                            'price' => $bundle->price,
                                            'stock' => $bundle->stock,
                                        ];
                                    @endphp
                                    @include('partials.cards.bundle',$bundle_data)

                                @endforeach

                            </div>

                        </div>
                        <div class="col"></div>
                    </div>

                </div>

                <div class="tab-pane fade" id="cupons" role="tabpanel" aria-labelledby="cupons-tab">
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('create_coupon', ['id' => \Illuminate\Support\Facades\Auth::id()]) }}"><button
                                type="button" class="btn btn-primary"> Add Cupon</button></a>
                    </div>
                    <div class="row mt-3"></div>
                    <div class="row mt-3"></div>
                    <div class="row row-cols-1 row-cols-md-2 g-4">

                        @foreach ($coupons as $coupon)

                            @php
                                $coupon_data = [
                                    'name' => $coupon->name,
                                    'amount' => $coupon->amount,
                                    'type' => $coupon->type,
                                    'expirationDate' => $coupon->expirationDate,
                                ];
                            @endphp
                            @include('partials.cards.coupon',$coupon_data)

                        @endforeach



                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
