<?php

namespace App\Http\Controllers;

use App\Models\ShipDetail;
use Illuminate\Http\Request;

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
    public function create(Request $request, $id)
    {
        //
        $shipDetail = Review::create([
            'client_id' => $id,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'address' => $request->input('address'),
            'door_n' => $request->input('door_n'),
            'post_code' => $request->input('post_code'),
            'district' => $request->input('district'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'phone_n' => $request->input('phone_n')
        ]);
        if ($request->has('floor')){
            $shipDetail->floor=$request->input('floor');
            $shipDetail->save();
        }
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
     * @param  \App\Models\ShipDetail  $shipDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShipDetail $shipDetail)
    {
        //
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
