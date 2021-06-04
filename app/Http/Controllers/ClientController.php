<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Item;
use App\Models\User;
use App\Models\Product;
use App\Models\TempPurchase;
use App\Models\Coupon;
use App\Models\CreditCard;
use App\Models\ShipDetail;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $this->authorize('viewAny');
        return Client::all();
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

        $request->validate([
            'client.email' => 'required|string',
            'client.password' => 'required|string',
            'client.name' => 'required|string',
            'client.image_id' => 'required|integer'
        ]);

        $user = User::create([
            'email' => $request->input('client.email'),
            'password' => $request->input('client.password')
        ]);

        Client::create([
            'id' => $user->id,
            'name' => $request->input('client.name'),
            'image_id' => $request->input('client.image_id')
        ]);

        return response('', 204)->header('description', 'Successfully created the client');
    }

    public function addRemoveFavorite(Request $request){
        $request->validate([
            'item_id' => 'required|int',
            'favorite' => 'required|int'
        ]);
        if ($request->favorite==1){
            \DB::table('client_item')->insert([
                'item_id' => $request->input('item_id'),
                'client_id' => Auth::user()->id]);
        }else{
            \DB::table('client_item')->where('item_id', '=', $request->item_id)->where('client_id','=',Auth::user()->id)->delete();
        }
        return response('', 204)->header('description', 'Successfully managed favorite');;
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Client $client)
    {
        $this->authorize('view', $client);

        $history_items = [];
        $favorite_items = [];
        $periodic_items = [];

        // Retrieve History and Periodic
        foreach ($client->purchases as $purchase){
            if ($purchase->type == 'SingleBuy'){
                foreach ($purchase->items as $item){
                    $product = $item->product();
                    if($product){
                        $item->unit = $product->unit;
                        $item->image = $product->images[0]->path;
                    } else {
                        $item->unit = "Un";
                        $item->image = "storage/products/bundle.jpg";
                    }
                    $item->status = $purchase->status;
                    array_push($history_items, $item);
                    
                }
                
            } else {
                foreach ($purchase->items as $item){
                    $product = $item->product();
                    if($product){
                        $item->unit = $product->unit;
                        $item->image = $product->images[0]->path;
                    } else {
                        $item->unit = "Un";
                        $item->image = "storage/products/bundle.jpg";
                    }
                    $item->purchase_type = $purchase->type;
                    array_push($periodic_items, $item);
                }
            }
        }

        // Retrieve Favorite items
        foreach ($client->item_favorites as $fav){
            $this->check_product($fav, $favorite_items);
        }

        // dd($client, $history_items, $favorite_items, $periodic_items);

        return view('pages.client.client_profile',
            ['client' => $client,
             'history' => $history_items,
             'favorites' => $favorite_items,
             'periodic' => $periodic_items
            ]);
    }

    private function check_product(Item $item, &$arr){
        $product = $item->product();
        if($product){
            $item->unit = $product->unit;
            $item->image = $product->images[0]->path;
        } else {
            $item->unit = "Un";
            $item->image = "storage/products/bundle.jpg";
        }
        array_push($arr, $item);
    }

    public function get_info(Client $client)
    {
        $this->authorize('view', $client);
        $user = User::find($client->id);
        return array_merge($client->toArray(), $user->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->authorize('view', $client);

        $validator = Validator::make($request->all(), [
            'email' => 'string|email|max:255',
            'password' => 'nullable|string|min:8',
            'name' => 'string',
            'image_id' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return new \Illuminate\Http\JsonResponse($validator->errors()->all(), 400);
        }

        $user = User::find($client->id);

        if($request->has('email')){
            $user->email = $request->input('email');
        }

        if($request->has('password') && !is_null($request->input('password'))){
            $user->password = Hash::make($request->input('password'));
        }

        if($request->has('name')){
            $client->name = $request->input('name');
        }

        if($request->has('image_id')){
            $client->image_id = $request->input('image_id');
        }

        $user->save();
        $client->save();

        return response('', 204,)->header('description', 'Successfully updated client information');
    }

    public function updateShipping(Request $request, Client $client){
        $this->authorize('view', $client);

        $ship_details = $client->ship_detail;

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'door_n' => 'required|integer',
            'post_code' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone_n' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new \Illuminate\Http\JsonResponse($validator->errors()->all(), 400);
        }

        $ship_details->update($request->all());

        return response('', 204,)->header('description', 'Successfully updated shipping information');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        $user = User::find($client->id);

        if(is_null($client) || is_null($user)){
            return abort(404);
        }
        //$client->delete();
        $user-> delete();

        return redirect()->route('homepage');
    }

    public function add_to_cart(Request $request){
        $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'quantity' => 'required|integer|gt:0',
            'item_id' => 'required|integer|exists:items,id',

        ]);

        $client_id = $request->input('client_id');
        $client = Client::find($client_id);

        $this->authorize('view', $client);

        $client->item_carts()->detach($request->input('item_id'));
        $client->item_carts()->attach($request->input('item_id'), ['quantity' => $request->input('quantity')]);


        $client->save();

        return response('', 201);
    }

    public function save_checkout(Request $request){

        $client_id = Auth::id();

        // $items = $client->item_carts;


        $request->validate([
            'n_items' => 'required|integer|gte:0',

            'periodic' => 'required',
        ]);


        $coupons_str = explode(' ', $request->input('all_coupons'));
        $coupons = [];

        if($request->input('all_coupons') !== null){
            foreach($coupons_str as $coupon){
                $ret_coupon = Coupon::find($coupon);

                array_push($coupons, $ret_coupon);
            }
        }


        //Update quantities
        $total = 0;

        for($i = 0; $i < $request->input('n_items'); $i++){
            $request->validate([
                'item_' . $i => 'required|integer|exists:items,id',
                'quantity_' . $i => 'required|integer|gte:0',
            ]);

            $id_item = $request->input('item_' . $i);
            $quantity = $request->input('quantity_' . $i);

            $item = Item::find($id_item);

            $item_tot_price = $item->price * $quantity;

            $already = false;
            foreach($coupons as $coupon){
                if($coupon->supplier_id === $item->supplier_id){
                    if($coupon->type === '%'){
                        $total += (1 - $coupon->amount/100) * $item_tot_price;
                    }else if($coupon->type === '€'){
                        $total += max(0, $item_tot_price - $coupon->amount);
                    }
                    $already = true;
                    break;
                }
            }

            if(!$already){
                $total += $item_tot_price;
            }


        }

        TempPurchase::where('client_id', $client_id)->delete();

        TempPurchase::create([
            'client_id' => $client_id,
            'total' => $total,
            'type' => $request->input('periodic'),
        ]);

        return redirect('client/' . $client_id . '/checkoutPayment');
    }

    public function checkout($id){

        if(!is_numeric($id)){
            return abort(404);
        }

        $this->authorize('view', Client::find($id));

        $client = Client::find($id);

        $items = $client->item_carts;

        if($items->isEmpty()){
            return redirect()->route('items');
        }

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

        if(!is_numeric($id)){
            return abort(404);
        }

        $this->authorize('view', Client::find($id));

        $client = Client::find($id);

        $items = $client->item_carts;

        if($items->isEmpty()){
            return redirect()->route('items');
        }

        $ccs = CreditCard::where('client_id', $id)
                ->where('to_save', true)->get();

        $ship_det = ShipDetail::where('client_id', $id)
                ->where('to_save', true)->get();

        $temp = TempPurchase::where('client_id', $id)->get()->first();

        $data = [
            'ccs' => $ccs,
            'total' => round($temp->total, 2),
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
        \DB::table('carts')->where("client_id", $client_id)->delete();


        Purchase::create([
            'client_id' => $client_id,
            'paid' => $temp->total,
            'sd_id' => $request->input('sd_id'),
            'cc_id' => $request->input('cc_id'),
            'type' => $temp->type,
        ]);

        $temp_builder->delete();
        return redirect('success');
    }

    public function updatePurchase(Request $request, Client $client){

        
        $this->authorize('view', $client);

        $request->validate([
            'product_id' => 'required|integer|exists:items,id'
        ]);

        $product_id = $request->input('product_id');
        

        foreach ($client->purchases as $purchase){
            foreach ($purchase->items as $item){
                
                if($item->id == $product_id){
                    
                    $purchase->status = 'Canceled';
                    $purchase->save();
                    return response('Canceled order', 204);
                }
            }

        }

        return abort(404);
    }
}
