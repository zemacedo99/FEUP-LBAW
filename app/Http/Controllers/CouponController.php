<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Supplier;
use App\Models\User;
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

        $coupon = Coupon::where('code', $couponCode)->get();

        if($coupon->isEmpty()){
            return abort(404,'Coupon not found');
        }
        return $coupon;
    }

    
    public function edit($couponCode)
    {   
        $coupon = Coupon::where('code', $couponCode)->first();

        //$this->authorize('update', $coupon);

        $data = [
                    'title' => 'Edit Coupon',
                    'path' => '/api/coupon/' . $coupon->code,
                    'code' => $coupon->code,
                    'description' => $coupon->description,
                    'name' => $coupon->name,
                    'expiration' => $coupon->expiration,
                    'amount' => $coupon->amount,
                    'type' => $coupon->type,
        ];

        if($coupon->type === "%"){
            $data['p'] = true;
        }else{
            $data['e'] = true;
        }
        return view('pages.supplier.create_edit_coupon', $data);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $couponCode)
    {   
        
        $request->validate([
            'coupon_amount' => 'numeric'            
        ]);
        
        $collection_coupon = Coupon::where('code', $couponCode)->get();
        
        $this->authorize('update', $collection_coupon->first());
        
        if($collection_coupon->isEmpty()){
            return abort(404,'Coupon not found');
        }

       
        $coupon = $collection_coupon->first();

        if($request->has('coupon_name')){
            $coupon->name = $request->input('coupon_name'); 
        }

        if($request->has('coupon_amount')){
            $coupon->amount = $request->input('coupon_amount'); 
        }

        if($request->has('coupon_type')){
            $coupon->type = $request->input('coupon_type'); 
        }

        if($request->has('description')){
            $coupon->description = $request->input('description'); 
        }

        if($request->has('date')){
            $coupon->expiration = $request->input('date'); 
        }
        
        $coupon->save();
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
    */
    public function destroy($couponCode)
    {   
        $coupon_builder = Coupon::where('code', '=', $couponCode);

        $this->authorize('delete', $coupon_builder->first());
        
        if($coupon_builder->get()->isEmpty()){
            return abort(404,'Coupon not found');
        }

        $coupon_builder->delete();

        return response('', 204)->header('description', 'Successfully removed coupon');
    }
}
