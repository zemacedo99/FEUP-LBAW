<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Tag;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\CreditCard;
use App\Models\Image;
use App\Models\Item;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\ShipDetail;
use App\Models\TempPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::all();
    }

    public function admin_list(Request $request)
    {
      
        $this->authorize('update',Item::class);
        
        $products=Item::orderby('active','desc')->orderBy('id','asc');

        $search=$request->search;
        if($search!=null){        
            $products=$products->whereRaw('search @@ to_tsquery(\'english\', ?)', [$search])
            ->orderByRaw('ts_rank(search, to_tsquery(\'english\', ?)) DESC', [$search]);
        }

        $products=$products->paginate(8);

        return view('pages.admin.products',['items'=>$products->withPath('dashboard_products')]);
    }

    /**
     * 
     */
    public function success(){

        return view('');
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

        $tags = Tag::get();

        $items = Item::where('supplier_id', '=', $id)->get();

        foreach($items as $item)
        {
            $product = Product::find($item->id);
        
            if(is_null($product))       // item is a bundle
            {
                continue;
            }
            else
            {
                $item->unit = $product->type;
                $item->images = $product->images()->get();
            }
            
        }

        $data = [
            'title' => 'Create Bundle',
            'path' => '/api/bundle',
            'alltags' => $tags,
            'products' => $items,
        ];

        return view('pages.supplier.create_edit_bundle', $data);
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
            'bundle_name' => 'required|string',
            'description' => 'required|string',
            'bundle_stock' => 'required|numeric',
            'bundle_price' => 'required|numeric',
            'supplierID' => 'required|integer',
        ]);

        $item = Item::create([
            'supplier_id' => $request->supplierID,
            'name' => $request->bundle_name,
            'price' => $request->bundle_price,
            'stock' => $request->bundle_stock,
            'description' => $request->description,
            'active' => true,
            'rating' => null,
            'is_bundle' => true,
        ]);



    
        $string = $request->t;
        $rtags = explode("/", $string); 
        // dd($rtags);


        if(is_null($request->tags))
        {
        //     dd("tags are emply");
        //     dd($request->tags);
        }
        else
        {
            foreach($rtags as $tagsValue)
            {
                // dd($tagsValue);
                if( is_null($tagsValue))
                {
                    continue;
                }
                if($tagsValue === "")
                {
                    continue;
                }


                $tags = Tag::where('value', $tagsValue)->get();
                // dd($tags);


                if (count($tags) > 0) {                     //if the tagvalue exist 
                    
                    foreach ($tags as $tag) {
                        $item->tags()->attach($tag);          // associate the tag to the item
                    }
                }
                else                                        // if the tagvalue is new
                {
                    $tag = Tag::create([                //create new tag
                        'value' => $tagsValue,   
                    ]);
                    $item->tags()->attach($tag);        // associate the tag to the item
                }
        
            }
        }


        // foreach($request->$products as $product)
        // {
        //     $item->contains_products()->attach($product);
        // }

        session()->flash('message','Bundle created successfully!');

        return redirect(route('create_bundle'  , ['id' => $request->supplierID]) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $item = Item::find($id);


        $data =
        [
            'id' => $id,
            'name' => $item->name,
            'price' => $item->price,
            'stock' => $item->stock,
            'description' => $item->description,
            'rating' => $item->rating,
            'is_bundle' => $item->is_bundle,
            'active'=>$item->active
        ];

        if(!$item->is_bundle){
            $product = Product::find($id);
            $data['unit'] = $product->unit;

            $images = $product->images()->get();
            // foreach($product->images as $image){
            //     $contents = Storage::disk('public')->get("images/" . $image->path);
            //     array_push($images, $contents);
            // }

            $data['images'] = $images;
        }
        else{
            $productsInBundle = $item->contains_products()->get();

            foreach($productsInBundle as $product)
            {
                $item = Item::find($product->id);
                $product->name = $item->name;
                $product->images = $product->images()->first();
                $product->quantity = $product->pivot->quantity;
            }

            $data['productsInBundle'] = $productsInBundle;
        }


        if(count($item->reviews)>0){
            $data['reviews'] =  $item->reviews;
        }

        if(count($item->tags)>0){

            $data['tags'] =  $item->tags;
        }

        $data['admin']=false;
        if(auth()->user()!=null){
            $data['admin'] = auth()->user()->is_admin;
        }






        return view('pages.misc.product_detail', $data);

    }


    public function storage_link($filename)
    {

        $path = storage_path('public/' . $filename);

        if (!Image::exists($path)) {
            return abort(404);
        }

        $image = Image::get($path);
        // $type = File::mimeType($path);

        // $response = Response::make($file, 200);
        // $response->header("Content-Type", $type);

        return $image;

    }


    public function list(Request $request)
    {

        $items = Item::where('active','=','true')->paginate(6);
        if($request->orderby != null)
        {
            switch (strval($request->orderby[0])) 
            {
                case "none":
                    break;
                case "Price Up":
                    $items = Item::where('active','=','true')->orderBy('price', 'desc')->paginate(6);
                    break;
                case "Price Down":
                    $items = Item::where('active','=','true')->orderBy('price', 'asc')->paginate(6);
                    break;
                case "Stock Up":
                    $items = Item::where('active','=','true')->orderBy('stock', 'desc')->paginate(6);
                    break;
                case "Stock Down":
                    $items = Item::where('active','=','true')->orderBy('stock', 'asc')->paginate(6);
                    break;
            }
        }


      

        foreach($items as $item)
        {
            $product = Product::find($item->id);
            $supplier = Supplier::find($item->supplier_id);

        
            if(is_null($product))       // item is a bundle
            {
                $item->unit = null;
                $item->image = null;
                $item->supplier = $supplier;
            }
            else
            {
                $item->unit = $product->unit;
                $item->images = $product->images()->get();
                $item->supplier = $supplier;
            }

        }


        return view('pages.misc.products_list', ["items" => $items]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        if(!is_numeric($id)){
            return abort(404, 'The item was not found');
        }
        return Item::find($id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        $supplier = Supplier::find($item->supplier_id);
        $alltags = Tag::get();
        $itemtags = $item->tags();

        $this->authorize('update', $item);

        $supplierItems = $supplier->items()->get();

        foreach($supplierItems as $item)
        {
            $product = Product::find($item->id);
        
            if(is_null($product))       // item is a bundle
            {
                continue;
            }
            else
            {
                $item->unit = $product->type;
                $item->images = $product->images()->get();
            }
            
            
   
        }


        $data = [
                    'title' => 'Edit Bundle',
                    'path' => '/api/item/' . $id,
                    'alltags' => $alltags,
                    'tags' => $itemtags,
                    'name' => $item->name,
                    'price' => $item->price,
                    'stock' => $item->stock,
                    'description' => $item->description,
                    'products' => $supplierItems,
        ];


        return view('pages.supplier.create_edit_bundle', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!is_numeric($id)){
            return abort(404, 'The item was not found');
        }

        $request->validate([
            'item.description' => 'string',
            'item.quantityAvailable' => 'integer',
            'item.price' => 'numeric',
            'item.name' => 'string',
        ]);



        $item = Item::find($id);
        $this->authorize('update', $item);

        if($item == null){
            return abort(404, 'The item was not found');
        }

        if($request->has('item.name')){
            $item->name = $request->input('item.name');
        }

        if($request->has('item.description')){
            $item->description = $request->input('item.description');
        }

        if($request->has('item.quantityAvailable')){
            $item->stock = $request->input('item.quantityAvailable');
        }

        if($request->has('item.price')){
            $item->price = $request->input('item.price');
        }

        $item->save();

        return response('', 204,)->header('description', 'Successfully updated item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
    
        if(!is_numeric($id)){
            return abort(404, 'The item was not found');
        }
        
        $item = Item::find($id);
        
        $this->authorize('delete', $item);


        if($item == null){
            return abort(404, 'The item was not found');
        }

        $item->active = 'false';

        $item->save();

        return response('', 204,)->header('description', 'Successfully deactivated item');

    }

    public function homePage(){
        $items=[
            'almostSoldOut'=>Item::orderBy('stock','asc')->take(5)->get(),
            'new'=>Item::orderBy('id','desc')->take(5)->get(),
            'hot'=>Item::take(5)->get()
        ];

        $Client = Client::find(Auth::id());

        foreach($items as $group){
            foreach($group as $item){
                $product = $item->product();
                if ($product){
                    $item->unit = $product->unit;
                    $item->image = $product->images[0]->path;
                } else {
                    $item->unit = "Un";
                    $item->image = "storage/products/bundle.jpg";
                }
                
                if ($Client!=null){
                    $item->favorite=$Client->item_favorites->contains($item);
                }
            }
        }

        return view('pages.misc.home_page',['items' => $items]);
    }
}
