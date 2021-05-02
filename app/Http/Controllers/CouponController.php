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
    {   //Testado!
        
        $request->validate([
            'supplierID' => 'required|integer'
        ]);
        
        return Coupon::where('supplier_id', '=', $request->input("supplierID"))->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        return view('pages.supplier.create_edit_coupon', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   //Continua com o erro do increment

        $this->authorize('create');

        $request->validate([
            'coupon.code' => 'required|string|unique:coupons,code',
            'coupon.name' => 'required|string',
            'coupon.description' => 'required|string',
            'coupon.amount' => 'required|numeric',
            'coupon.expirationDate' => 'required|string',
            'coupon.unit' => 'required|string',
            'coupon.supplierID' => 'required|integer'
        ]);

        Coupon::create([
            'code' => $request->input('coupon.code'),
            'name' => $request->input('coupon.name'),
            'description' => $request->input('coupon.description'),
            'expiration' => $request->input('coupon.expirationDate'),
            'amount' => $request->input('coupon.amount'),
            'type' => $request->input('coupon.unit'),
            'supplier_id' => $request->input('coupon.supplierID'),
        
        ]);

        return response('', 204)->header('description', 'Successfully added item');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show($couponCode)
    {   // Testado
        $coupon = Coupon::where('code', '=', $couponCode)->get();

        if($coupon->isEmpty()){
            return response('', 404)->header('description', 'Coupon not found');
        }
        return $coupon;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $couponCode)
    {   //Testado!
        
        
        $collection_coupon = Coupon::where('code', '=', $couponCode)->get();
        
        $this->authorize('update', $collection_coupon);
        
        if($collection_coupon->isEmpty()){
            return response('', 404)->header('description','Coupon not found');
        }

       
        $coupon = $collection_coupon->first();

        if($request->has('coupon.name')){
            $coupon->name = $request->input('coupon.name'); 
        }

        if($request->has('coupon.amount')){
            $coupon->amount = $request->input('coupon.amount'); 
        }

        if($request->has('coupon.unit')){
            $coupon->type = $request->input('coupon.unit'); 
        }

        if($request->has('coupon.description')){
            $coupon->description = $request->input('coupon.description'); 
        }

        if($request->has('coupon.expirationDate')){
            $coupon->expiration = $request->input('coupon.expirationDate'); 
        }
        
        $coupon->save();
        
        return response('', 204,)->header('description', 'Successfully updated coupon');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
    */
    public function destroy($couponCode)
    {   //Testado
        $coupon_builder = Coupon::where('code', '=', $couponCode);

        $this->authorize('delete', $coupon_builder->get());
        
        if($coupon_builder->get()->isEmpty()){
            return response('', 404,)->header('description', 'Coupon not found');
        }

        $coupon_builder->delete();

        return response('', 204,)->header('description', 'Successfully removed coupon');
    }
}
