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


    public function save_checkout(Request $request){

        $client_id = Auth::id();

        $client = Client::find($client_id);

        // $items = $client->item_carts;


        $request->validate([
            'n_items' => 'required|integer',
            'periodic' => 'required',
            'all_coupons' => 'required',
        ]);


        $coupons_str = explode(' ', $request->input('all_coupons'));
        $coupons = [];

        foreach($coupons_str as $coupon){
            array_push($coupons, Coupon::find($coupons_str));
        }

        //Update quantities
        $total = 0;

        for($i = 0; $i < $request->input('n_items'); $i++){
            $request->validate([
                'item_' . $i => 'required|integer',
                'quantity_' . $i => 'required|integer',
            ]);

            $id_item = $request->input('item_' . $i);
            $quantity = $request->input('quantity_' . $i);

            // foreach($items as $item){
            //     if($item->id == $id_item){
            //         $item->quantity = $quantity;
            //         break;
            //     }
            // }

            $item = Item::find($id_item);

            $item_tot_price = $item->price * $quantity;

            foreach($coupons as $coupon){
                if($coupon->supplier_id === $item->supplier_id){
                    if($coupon->type === '%'){
                        $total +=  (1 - $coupon->amount/100) * $item_tot_price;
                    }else{
                        $total +=  max(0, $item_tot_price - $coupon->amount);
                    }
                }
            }
        }

        TempPurchase::create([
            'client_id' => $client_id,
            'total' => $total,
            'type' => $request->input('periodic'),
        ]);

        redirect()->route('payment');
    }


    public function checkout($id){

        if(!is_numeric($id))
            return response('', 404);

        $client = Client::find($id);
        $items = $client->item_carts;

        $total = 0;
        foreach($items as $item){
            $product = Product::find($item->id);
            $total += $item->price * $item->pivot->quantity;

            if($product == null) continue;


            $images = $product->images;

            $item['image'] = $images[0]->path;
        }

        $data = [

            'items' => $items,
            'total' => $total,
        ];
        return view('pages.checkout.cart_info', $data);
    }


    public function payment($id){
        // Falta validação

        $ccs = CreditCard::where('client_id', $id)
                ->where('to_save', true)->get();

        $ship_det = ShipDetail::where('client_id', $id)
                ->where('to_save', true)->get();

        $data = [
            'ccs' => $ccs,
        ];

        if($ship_det != []){
            $data['sd'] = $ship_det->first();
        }

        return view('pages.checkout.shipping_payment', $data);
    }

    public function do_payment(Request $request){

        $request->validate([
            'cc_id' => 'required|integer|exists:credit_cards,id',
            'sd_id' => 'required|integer|exists:ship_details,id',
        ]);

        $client_id = Auth::id();

        $temp_builder = TempPurchase::where('client_id', $client_id);

        $temp = $temp_builder->get()->first();

        //Deleting carts
        Client::find(Auth::id())->item_carts->newPivotStatement()->where('client_id', $client_id)->delete();

        $purchase = Purchase::create([
            'client_id' => $client_id,
            'paid' => $temp->total,
            'sd_id' => $request->input('sd_id'),
            'cc_id' => $request->input('cc_id'),
            'type' => $temp->type,
        ]);

        $temp_builder->delete();
        redirect('/');
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

        $data = [
            'title' => 'Create Bundle',
            'path' => '/api/bundle',
            'tags' => $tags,
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
            'rating' => 0,
            'is_bundle' => true,
        ]);


        if(is_null($request->tags))
        {
            dd("error here");
            dd($request->tags);
        }
        else
        {
            foreach($request->tags as $tagsValue)
            {
                if( is_null($tagsValue))
                {
                    break;
                }
                $tags = Tag::where('value', $tagsValue)->get();

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
            'name' => $item->name,
            'price' => $item->price,
            'stock' => $item->stock,
            'description' => $item->description,
            'rating' => $item->rating,
            'is_bundle' => $item->is_bundle,
        ];

        if(!$item->is_bundle){
            $product = Product::find($id);
            $data['unit'] = $product->type;

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
            }
        }

        return view('pages.misc.home_page',['items' => $items]);
    }
}
