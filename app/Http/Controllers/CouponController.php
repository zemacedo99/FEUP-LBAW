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
        $request->validate([
            'supplierID' => 'required|integer'
        ]);
        return Coupon::where('supplier_id', '=', $request->input("supplierId"))->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $coupon)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'name' => 'required|string',
            'description' => 'required|string',
            'expiration' => 'required|string',
            'type' => 'required|integer',
            'supplierID' => 'required|integer'
        ]);

        $created_coupon = Coupon::create($coupon);

        return $created_coupon;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $couponCode)
    {
        $request->validate([
            'couponCode' => 'required|string|unique:coupons,code'
        ]);

        return Coupon::where('code', '=', $couponCode)->get();        
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
            $coupon->name = $request->input('name'); 
        }

        if($request->has('amount')){
            $coupon->name = $request->input('amount'); 
        }

        if($request->has('unit')){
            $coupon->name = $request->input('unit'); 
        }

        if($request->has('description')){
            $coupon->name = $request->input('description'); 
        }

        if($request->has('expirationDate')){
            $coupon->name = $request->input('expirationDate'); 
        }
        
        $coupon->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'couponCode' => 'required|string|unique:coupons,code'
        ]);
        
        Coupon::where('code', '=', $request->input("couponCode"))->delete();
    }
}
