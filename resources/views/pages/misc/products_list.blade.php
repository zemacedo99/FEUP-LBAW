@extends('layouts.app')

@section('content')

<script type="text/javascript" src={{ asset('js/order_by.js') }} defer> </script>

@include('partials.filters')

<div id="mainContainer" class="container">
    <div class="row mb-3 mt-5">
        <div class="col-3">
            @isset($items)<h3> Products </h3> @endisset
            @isset($suppliers)<h3> Stores </h3> @endisset
        </div>
        <div class="col d-inline-flex justify-content-end mb-1">
            <button id="sidebar-toggler" class="btn bd-sidebar-toggle btn-primary" style="width: max-content;"
                type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="filters"
                aria-expanded="false" aria-label="toggle-filters">
                Filters
            </button>
        </div>
        @isset($items)
            <form class="d-flex" method="GET" action="/items">
                @include('partials.order_by')
            </form>
        @endisset
    </div>

    <div class="row">
        @isset($items)
            @foreach ( $items as $item)
            
                @include('partials.cards.product_detail',[
                    'id' => $item->id,
                    'is_bundle' => $item->is_bundle,
                    'name' => $item->name,
                    'price' => $item->price,
                    'description' => $item->description,
                    'rating' => $item->rating,
                    'unit' => $item->unit,
                    'images' => $item->images,
                    'supplier' => $item->supplier,
                    ])
            @endforeach
            @include('partials.pages',['link'=>"items",'paginator'=>$items])
        @endisset

        @isset($suppliers)
            @foreach ( $suppliers as $supplier)
                @include('partials.cards.supplier',[
                    'id' => $supplier->id,
                    'name' => $supplier->name,
                    'address' => $supplier->address,
                    'description' => $supplier->description,
                    'image' => $supplier->image,
                    ])
            @endforeach
            @include('partials.pages',['link'=>"suppliers",'paginator'=>$suppliers])
        @endisset
    </div>
    
</div>


@endsection
