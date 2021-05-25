@extends('layouts.app')

@section('content')

    <div id="mainContainer" class="container">

        <div class="row mt-5 ">
            <div class="col-3" style="width: 15rem;">
                <img src="{{ asset($image->path) }}" class="rounded-circle img-fluid">
            </div>
            <div class="col-8 sm-12">
                <div class="col-9 mt-3">
                    <h3>{{ $name }}</h3>

                    <p class="text-muted"><i>{{ $address }}</i></p>

                    @for ($i = 0; $i < 5; $i++)

                        @if ($i < $stars) 
                        <i class="bi bi-star-fill"></i>
                        @else 
                        <i class="bi bi-star"></i>
                        @endif

                    @endfor
                </div>
            </div>
            <div class="col-1 mt-3">
                <i class="bi bi-envelope"></i>
            </div>
        </div>

        <div class="row mt-5 mb-5">
            <p class="text-start rounded" style="background-color: #F3F2F4;">
                {{$description}}
            </p>
        </div>

        <div class="row mb-3">
            <div class="col-3">
                <h3> Products </h3>
            </div>
            @include('partials.order_by')
        </div>

        <div class="row">
            @foreach ($items as $item)
                @php
                $data = 
                [   
                    'id' => $item[0]->id,
                    'is_bundle' => $item[0]->is_bundle,
                    'name' => $item[0]->name,
                    'price' => $item[0]->price,
                    'description' => $item[0]->description,
                    'rating  ' => $item[0]->rating,
                    'unit' => $item[1],
                    'images' => $item[2],
                ];
                @endphp
                @include('partials.cards.product_detail',$data) 
            @endforeach
            @include('partials.page_navigation')
        </div>

    @endsection
