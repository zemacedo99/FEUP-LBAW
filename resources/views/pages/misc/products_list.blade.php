@extends('layouts.app')

@section('content')


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
        @include('partials.order_by')
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
                'name' => $supplier[0]->name,
                'address' => $supplier[0]->address,
                'description' => $supplier[0]->description,
                'image' => $supplier[1],
                ])
            @endforeach
            {{-- @include('partials.pages',['link'=>"items",'paginator'=>$items]) --}}
        @endisset
    </div>
    
</div>


@endsection
