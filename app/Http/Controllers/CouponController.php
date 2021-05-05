<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
    public function create($id)
    {
        $supplier = Supplier::find($id);
        $this->authorize('create', $supplier);
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
    {   

        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'coupon_name' => 'required|string',
            'description' => 'required|string',
            'coupon_amount' => 'required|numeric',
            'date' => 'required|string',
            'coupon_type' => 'required|string',
            'supplierID' => 'required|integer'
        ]);
        
        $supplier = Supplier::find($request->supplierID);

        $this->authorize('create', $supplier);

        Coupon::create([
            'code' => $request->code,
            'name' => $request->coupon_name,
            'description' => $request->description,
            'expiration' => $request->date,
            'amount' => $request->coupon_amount,
            'type' => $request->coupon_type,
            'supplier_id' => $request->supplierID,
        ]);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show($couponCode)
    {   

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
