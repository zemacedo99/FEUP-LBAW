<?php

namespace App\Http\Controllers;

use App\Models\ShipDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        return ShipDetail::where('client_id','=',$id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   

        ShipDetail::where('client_id', Auth::id())->delete();
        

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'door_n' => 'required|integer',
            'post_code' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone_n' => 'required|string',
            'to_save' => 'required',
        ]);
        

        $shipDetail = ShipDetail::create([
            'client_id' => Auth::id(),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'address' => $request->input('address'),
            'door_n' => $request->input('door_n'),
            'post_code' => $request->input('post_code'),
            'district' => $request->input('district'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'phone_n' => $request->input('phone_n'),
            'to_save' => $request->input('to_save'),
        ]);


        return $shipDetail;
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
     * @param  \App\Models\ShipDetail  $shipDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ShipDetail $shipDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShipDetail  $shipDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(ShipDetail $shipDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id  clientId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $shipDetail = ShipDetail::where('id', '=', $request->input('shipDetail_id'))->get();
        
        $this->authorize('update', $shipDetail);
        
        if($shipDetail->isEmpty()){
            return abort(404, 'shipDetail not found');
        }

        if($request->has('first_name')){
            $shipDetail->first_name = $request->input('first_name'); 
        }

        if($request->has('last_name')){
            $shipDetail->last_name = $request->input('last_name'); 
        }

        if($request->has('address')){
            $shipDetail->address = $request->input('address'); 
        }

        if($request->has('door_n')){
            $shipDetail->door_n = $request->input('door_n'); 
        }

        if($request->has('post_code')){
            $shipDetail->post_code = $request->input('post_code'); 
        }

        if($request->has('district')){
            $shipDetail->district = $request->input('district'); 
        }

        if($request->has('city')){
            $shipDetail->city = $request->input('city'); 
        }

        if($request->has('country')){
            $shipDetail->country = $request->input('country'); 
        }

        if($request->has('phone_n')){
            $shipDetail->phone_n = $request->input('phone_n'); 
        }
        
        $shipDetail->save();
        
        return response('', 204,)->header('description', 'Successfully updated shipDetail');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShipDetail  $shipDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShipDetail $shipDetail)
    {
        //
    }
}
