<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        
        $request->validate([
            'supplierID' => 'required|integer'
        ]);
        
        return Product::where('supplier_id', '=', $request->input("supplierID"))->get();

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $supplier = Supplier::find($id);
        $this->authorize('create', $supplier);
        $data = [
                    'title' => 'Create Product',
                    'path' => '/api/product'        
                ];

        return view('pages.supplier.create_edit_product', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $request->validate([
            'product_name' => 'required|string',
            'description' => 'required|string',
            'product_stock' => 'required|numeric',
            'product_price' => 'required|numeric',
            'product_type' => 'required|string',
            'supplierID' => 'required|integer',
            // 'sup_img' => '' 
        ]);
        
        $supplier = Supplier::find($request->supplierID);

        $this->authorize('create', $supplier);

        Product::create([
            'name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'type' => $request->product_type,
            'stock' => $request->stock,
            'tags' => $request->tags
        ]);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
