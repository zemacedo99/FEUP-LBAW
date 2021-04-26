<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        return Purchase::where('client_id','=',$id)->get();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {

        //if (!Auth::check()) return redirect('/login');

        //
        $purchase = new Purchase();

        $this->authorize('create', $purchase);
        $purchase->client_id=$id;
        $purchase->paid=$request->input("paid");
        $purchase->type=$request->input("type");
        $purchase->purchase_date=Carbon::now()->toDateString();
        $purchase->save();

        $carts=DB::table('carts')->where('client_id', '=', $id)->get();

        foreach ($carts as $cart){
            $item_purchase = new ItemPurchase();
            $this->authorize('create', $item_purchase);
            $item_purchase->purchase_id=$purchase->id;
            $item_purchase->item_id=$cart->item_id;
            $item_purchase->price;
            $item_purchase->amount;
            $item_purchase->save();
        }
        // $purchase->name = $request->input('name');
        // $purchase->user_id = Auth::user()->id;


        return $purchase;
        
    }

    
}
