<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\Product;
use App\Models\TempPurchase;
use App\Models\Coupon;
use App\Models\CreditCard;
use App\Models\ShipDetail;
use App\Models\Purchase;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
                    if($item->product()){
                        array_push($history_items, array_merge($item->toArray(),
                            $item->product()->toArray(),
                            ["image" => $item->product()->images[0]->path]));
                    } else {
                        array_push($history_items, array_merge($item->toArray(), ["unit" => "Un",
                            "image" => "storage/products/bundle.jpg"]));
                    }
                }
            } else {
                foreach ($purchase->items as $item){
                    if(!is_null($item->product())){
                        array_push($periodic_items, array_merge($item->toArray(),
                            $item->product()->toArray(),
                            ["image" => $item->product()->images[0]->path, "type" => $purchase->type]));
                    } else {
                        array_push($periodic_items, array_merge($item->toArray(), ["unit" => "Un",
                            "image" => "storage/products/bundle.jpg", "type" => $purchase->type]));
                    }
                }
            }

        }

        // Retrieve Favorite items
        foreach ($client->item_favorites as $fav){
            if(!is_null($fav->product())){
                array_push($favorite_items, array_merge($fav->toArray(),
                    $fav->product()->toArray(),
                    ["image" => $fav->product()->images[0]->path]));
            } else {
                array_push($favorite_items, array_merge($fav->toArray(), ["unit" => "Un",
                    "image" => "storage/products/bundle.jpg"]));
            }
        }

        return view('pages.client.client_profile',
            ['client' => $client,
             'history' => $history_items,
             'favorites' => $favorite_items,
             'periodic' => $periodic_items
            ]);
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
    public function update(Request $request, $id)
    {   // Testado!


        $request->validate([
            'client.email' => 'string',
            'client.password' => 'string',
            'client.name' => 'string',
            'client.image_id' => 'integer'
        ]);

        if(!is_numeric($id)){
            return response('', 404)->header('description','The client was not found');
        }

        $client = Client::where('id', '=', $id)->get();
        $this->authorize('viewAny', $client);

        $user = User::where('id', '=', $id)->get();


        if($client->isEmpty()){
            return response('', 404)->header('description','The client was not found');
        }

        $client_data = $client->first();
        $user_data = $user->first();

        if($request->has('client.email')){
            $user_data->email = $request->input('client.email');
        }

        if($request->has('client.password')){
            $user_data->password = $request->input('client.password');
        }

        if($request->has('client.name')){
            $client_data->name = $request->input('client.name');
        }

        if($request->has('client.image_id')){
            $client_data->image_id = $request->input('client.image_id');
        }

        $user_data->save();
        $client_data->save();

        return response('', 204,)->header('description', 'Successfully updated client information');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   //postgres não deixa apagar
        $client = Client::where('id', '=', $id);
        $this->authorize('viewAny', $client);

        $user = User::where('id', '=', $id);

        if($client->get()->isEmpty() || $user->get()->isEmpty()){
            return response('', 404,)->header('description', 'Client not found');
        }

        $client->delete();
        $user-> delete();

        return response('', 204,)->header('description', 'Successfully deleted the client');
    }



    public function save_checkout(Request $request){
    
        $client_id = Auth::id();

        // $items = $client->item_carts;
        
        
        $request->validate([
            'n_items' => 'required|integer',
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
                'item_' . $i => 'required|integer',
                'quantity_' . $i => 'required|integer',
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
        // Falta validação
        
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
}
