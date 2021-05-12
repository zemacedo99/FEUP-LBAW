<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


    // function uploadImg(Request $req)
    // {
    //     return $req->file('sup_img')->store('public/images');
    // }

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



    // public function uploadSubmit(Request $request)
    // {
    //     $this->validate($request, [
    //         'name' => 'required',
    //         'photos' => 'required',
    //     ]);
    //     if ($request->hasFile('photos')) {
    //         $allowedfileExtension = ['pdf', 'jpg', 'png', 'docx'];
    //         $files = $request->file('photos');
    //         foreach ($files as $file) {
    //             $filename = $file->getClientOriginalName();
    //             $extension = $file->getClientOriginalExtension();
    //             $check = in_array($extension, $allowedfileExtension);
    //             //dd($check);
    //             if ($check) {
    //                 $items = Item::create($request->all());
    //                 foreach ($request->photos as $photo) {
    //                     $filename = $photo->store('photos');
    //                     ItemDetail::create([
    //                         'item_id' => $items->id,
    //                         'filename' => $filename
    //                     ]);
    //                 }
    //                 echo "Upload Successfully";
    //             } else {
    //                 echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
    //             }
    //         }
    //     }
    // }


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
            'supplierID' => 'required|integer',
            // 'images' => 'required',            // 'sup_img' => '' 
        ]);




        if ($request->has('images')) {

            // dd($request->file('images'));
            foreach ($request->file('images') as $image) {
                $filename = $image->getClientOriginalName();
                // dd($filename);
                // dd($image);
                $image->store('public/images');

                Image::create([
                    'path' => $filename
                ]);
            }
        }

        // $request->file('image')->store('public/images');


        // $supplier = Supplier::find($request->supplierID);

        // $this->authorize('create', $supplier);

        $item = Item::create([
            'supplier_id' => $request->supplierID,
            'name' => $request->product_name,
            'price' => $request->product_price,
            'stock' => $request->product_stock,
            'description' => $request->description,
            'active' => true,
            'rating' => 0,
            'is_bundle' => false,

            // 'tags' => $request->tags,
        ]);


        // dd($item->id);

        Product::create([
            'id' => $item->id,
            'type' => $request->product_type,
        ]);


        return redirect('/items');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if ($product->isEmpty()) {
            return response('', 404)->header('description', 'Product not found');
        }
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
