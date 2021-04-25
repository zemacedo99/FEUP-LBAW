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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if (!Auth::check()) return redirect('/login');

        //
        $purchase = new Purchase();

        $this->authorize('create', $purchase);
        $purchase->client_id=$request->user_id;
        //$purchase->paid
        $purchase->purchase_date=Carbon::now()->toDateString();
        $purchase->save();

        $carts=DB::table('carts')->where('client_id', '===', $request->client_id)->get();

        foreach ($carts as $cart){
            $item_purchase = new ItemPurchase();
            $this->authorize('create', $item_purchase);
            $item_purchase->purchase_id=$purchase->id;
            $item_purchase->item_id=$cart->item_id;
            // $item_purchase->price
            // $item_purchase->amount
            $item_purchase->save();
        }
        // $purchase->name = $request->input('name');
        // $purchase->user_id = Auth::user()->id;


        return $purchase;
        
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
