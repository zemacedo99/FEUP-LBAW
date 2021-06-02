<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Item;
use App\Models\Product;
use App\Models\Search;
use App\Models\Supplier;
use Illuminate\Http\Request;


class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function text_search($stores,$products,$search)
    {
        $filters_array = [];

        if($stores)
        {
            $suppliers = Supplier::whereRaw('search @@ to_tsquery(\'english\', ?)', [$search])
            ->orderByRaw('ts_rank(search, to_tsquery(\'english\', ?)) DESC', [$search])->paginate(6);
            $suppliers->appends(['search' => $search])->links();

            return $suppliers;
        }
        elseif($products)
        {
            $items = Item::whereRaw('search @@ to_tsquery(\'simple\', ?)', [$search])
            ->orderByRaw('ts_rank(search, to_tsquery(\'simple\', ?)) DESC', [$search])->paginate(6);

            $items->appends(['search' => $search])->links();


            return $items;
        }

    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      

        $search = $request->search;
        
        $stores = boolval($request->input('storesOption', '0'));
        $products = boolval($request->input('productsOption','1'));


        if($stores)
        {
            $suppliers = $this->text_search($stores,$products,$search);
            $data =
            [
                'suppliers' => $suppliers,
            ];
        }
        else
        {
            $items = $this->text_search($stores,$products,$search);
            $data =
            [
                'items' => $items,
            ];
        }

        // dd($search);

        // foreach($suppliers as $supplier)
        // {
        //     $image = Image::find($supplier->image_id);
        //     $supplier->image = $image;
        // }

        // foreach($items as $item)
        // {
        //     $product = Product::find($item->id);
        //     $supplier = Supplier::find($item->supplier_id);

        
        //     if(is_null($product))       // item is a bundle
        //     {
        //         $item->unit = null;
        //         $item->image = null;
        //         $item->supplier = $supplier;
        //     }
        //     else
        //     {
        //         $item->unit = $product->unit;
        //         $item->images = $product->images()->get();
        //         $item->supplier = $supplier;
        //     }

        // }

 
        
        return view('pages.misc.products_list', $data);
    }



    public function filter(Search $search)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function edit(Search $search)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Search $search)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function destroy(Search $search)
    {
        //
    }
}
