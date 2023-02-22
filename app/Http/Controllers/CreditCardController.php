<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditCardController extends Controller
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
        $request->validate([
            'card_number' => 'required|size:16',
            'valid_until' => 'required',
            'cvv' => 'required|integer',
            'holder_name' => 'required',
            'to_save' => 'required',
        ]);
        
        $cc = CreditCard::create([
            'card_n' => $request->input('card_number'),
            'expiration' => $request->input('valid_until'),
            'cvv' => $request->input('cvv'),
            'holder' => $request->input('holder_name'),
            'client_id' => Auth::id(),
            'to_save' => $request->input('to_save'),
        ]);

        return $cc;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CreditCard  $creditCard
     * @return \Illuminate\Http\Response
     */
    public function show(CreditCard $creditCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CreditCard  $creditCard
     * @return \Illuminate\Http\Response
     */
    public function edit(CreditCard $creditCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CreditCard  $creditCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'card_n' => 'string',
            'expiration' => 'string',
            'cvv' => 'integer',
            'holder' => 'string',
            'id' => 'required|integer',
        ]);

        $collection_cc = CreditCard::where('id', $request->input('id'))->get();
        
        
        if($collection_cc->isEmpty()){
            return abort(404,'Coupon not found');
        }

       
        $cc = $collection_cc->first();

        if($request->has('card_n')){
            $cc->card_n = $request->input('card_n'); 
        }

        if($request->has('expiration')){
            $cc->expiration = $request->input('expiration'); 
        }

        if($request->has('cvv')){
            $cc->cvv = $request->input('cvv'); 
        }

        if($request->has('holder')){
            $cc->holder = $request->input('holder'); 
        }
        
        $cc->save();
        
        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CreditCard  $creditCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:credit_cards,id'
        ]);

        $cc_builder = CreditCard::where('id', $request->input('id'));

        // $this->authorize('delete', $coupon_builder->get());

        $cc_builder->delete();

        return response('', 200,)->header('description', 'Successfully removed creditcard');
    }
}
