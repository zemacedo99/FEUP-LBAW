<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Coupon::where('supplier_id', '=', $request->input("supplierId"))->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $coupon = Coupon::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'expiration' => $request->input('expiration'),
            'type' => $request->input('type'),
            'supplier_id' => $request->input('supplier_id'),
        ]);
        return $coupon;
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
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return Coupon::where('code', '=', $request->input("couponCode"))->get();        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $coupon = Coupon::where('code', '=', $request->input("couponCode"))->get();
        if($request->has('name')){
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }
}
