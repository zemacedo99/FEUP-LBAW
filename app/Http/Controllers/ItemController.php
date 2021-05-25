<?php

namespace App\Http\Controllers;

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

    public function admin_list()
    {
        if(auth()->user()==null||!auth()->user()->is_admin){
            return response('', 404)->header('description','Page does not exist');
        }
        $products=Item::orderBy('id','asc')->paginate(8);

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


        $data = [];
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
        $this->authorize('create');

        $request->validate([
            'item.supplier_id' => 'required|integer',
            'item.name' => 'required|string',
            'item.price' => 'required|numeric',
            'item.quantityAvailable' => 'required|integer',
            'item.description' => 'required|string',
            'item.bundle' => 'required|boolean',
        ]);

        $item = Item::create([
            'supplier_id' => $request->input('item.supplier_id'),
            'name' => $request->input('item.name'),
            'price' => $request->input('item.price'),
            'stock' => $request->input('item.quantityAvailable'),
            'description' => $request->input('item.description'),
            'active' => 'true',
            'is_bundle' => $request->input('item.bundle'),
        ]);

        // Não sei se está certo
        if($request->has('item.tags')){
            $tags = $request->input('item.tags');
            $item->tags = $tags;
        }

        if($request->input('item.bundle') == false){

            $product = Product::create([
                'unit' => $request->input('item.type')
            ]);


            if($request->has('item.images')){
                $paths = [];
                foreach($request->file('imageFile') as $image)
                {
                    $path = $image->store('/public/images');
                    array_push($paths, $path);

                    Image::create([
                        'path' => $path
                    ]);

                }
                $product->images = $paths;
            }
        }

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
            abort(404);
        }

        $image = Image::get($path);
        // $type = File::mimeType($path);

        // $response = Response::make($file, 200);
        // $response->header("Content-Type", $type);

        return $image;

    }

    // nao pode ser feito assim, é suposto retornar a vista com todos os items
    public function list()
    {
        $items = Item::get();

        // $data =
        // [
        //     'name' => $item->name,
        //     'price' => $item->price,
        //     'description' => $item->description,
        //     'rating' => $item->rating,
        // ];

        return view('pages.misc.products_list', ['items' => $items]);

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
            return response('', 404)->header('description','The item was not found');
        }
        return Item::find($id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
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
            return response('', 404)->header('description','The item was not found');
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
            return response('', 404)->header('description','The item was not found');
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
    public function deactivate(Request $id)
    {
        if(!is_numeric($id)){
            return response('', 404)->header('description','The item was not found');
        }

        $item = Item::find($id);
        $this->authorize('delete', $item);

        if($item == null){
            return response('', 404)->header('description','The item was not found');
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
