<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Image;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\Request;

class SupplierController extends Controller
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

    public function get_info(Supplier $supplier)
    {
        $this->authorize('view', $supplier);
        $user = User::find($supplier->id);
        return array_merge($supplier->toArray(), $user->toArray());
    }

    public function list()
    {
        $suppliers = Supplier::paginate(6);

        // $all = [];
        // $i = 0;
        foreach($suppliers as $supplier)
        {
            
            $image = Image::find($supplier->image_id);
            $supplier->image = $image;
            
            
            // $i++;
        }

        $data =
        [
            'suppliers' => $suppliers,
        ];

        return view('pages.misc.products_list',$data);
    }


    public function allProducts($id)
    {
        $supplier = Supplier::find($id);

        $image = Image::find($supplier->image_id);
        $items = Item::where('supplier_id', '=', $id)->paginate(6);

        foreach($items as $item)
        {
            $product = Product::find($item->id);
    
            if(is_null($product))       // item is a bundle
            {
                $item->unit = null;
                $item->image = null;
                $item->supplier = $supplier;
            }
            else
            {
                $item->unit = $product->unit;
                $item->images = $product->images()->get();
            }
        }

        $data = 
        [
            'name' => $supplier->name,
            'items' => $items,
            'image' =>$image,
        ];


        return view('pages.supplier.all_products',$data);
    }

    public function bundles_and_coupons($id)
    {
        
        //todo: policies

        $items = Item::where('supplier_id', '=', $id)->get();
        $coupons = Coupon::where('supplier_id', '=', $id)->get();


        $bundles = [];

        $i = 0;
        foreach($items as $item)
        {
        
            if($item->is_bundle)       // item is a bundle
            {
                $bundles[$i] = $item;
            }
            
            
            $i++;
        }

        $data = 
        [
            'bundles' => $bundles,
            'coupons' => $coupons,
        ];



        return view('pages.supplier.bundles_and_coupons',$data);
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
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function supplier_detail($id)
    {

        $supplier = Supplier::find($id);

        $image = Image::find($supplier->image_id);
        $items = Item::where('supplier_id', '=', $id)->paginate(4);
        $alltems = Item::where('supplier_id', '=', $id)->get();

        $stars = 0;
        $i = 0;
        foreach($alltems as $item)  // probably there is a better way to do this
        {
            $stars = $stars + $item->rating;
            $i++;
        }

        $stars = $stars / $i;


       
        foreach($items as $item)
        {
            $product = Product::find($item->id);
    
            if(is_null($product))       // item is a bundle
            {
                $item->unit = null;
                $item->image = null;
                $item->supplier = $supplier;
            }
            else
            {
                $item->unit = $product->unit;
                $item->images = $product->images()->get();
            }
        }


        $data =
        [
            'supplier' => $supplier,
            'name' => $supplier->name,
            'address' => $supplier->address,
            'post_code' => $supplier->post_code,
            'city' => $supplier->city,
            'description' => $supplier->description,
            'image' => $image,
            'stars' => $stars,
            'items' => $items,
        ];

        return view('pages.misc.supplier_detail', $data);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);

        //todo: verificar questões de segurança
        $email = auth()->user()->email;
        $password =  auth()->user()->password;

        $items =  $supplier->items()->get();
        $all = [];

        $i = 0;
        foreach($items as $item)
        {
            $product = Product::find($item->id);

            if(is_null($product))       // item is a bundle
            {
                $all[$i] = [$item,null,null];
            }
            else
            {
                $all[$i] = [$item,$product->type,$product->images()->get()];
            }
            
            
            $i++;
        }


        $data = 
        [
            'path' => '/api/supplier/' . $id,
            'id' => $supplier->id,
            'name' => $supplier->name,
            'email' => $email,
            'password' =>$password,
            'address' => $supplier->address,
            'post_code' =>$supplier->post_code,
            'city' => $supplier->city,
            'description' => $supplier->description,
            'items' => $all,
        ];




        return view('pages.supplier.supplier_profile',$data);
    }

    public function requests(){
        if(auth()->user()==null||!auth()->user()->is_admin){
            return abort(404, 'Page does not exist');
        }

        $suppliers=Supplier::where('accepted', 'false')->paginate(8);

        return view('pages.admin.requests',['suppliers'=>$suppliers]);
    }

    public function requestHandling(Request $request){
        if ($request->accept=="1"){
            Supplier::where('id','=',$request->supplier_id)->update(['accepted'=>"true"]);
        }else{
            //return Supplier::where('id','=',$request->supplier_id)->get();
            //Supplier::where('id','=',$request->supplier_id)->delete();//not working
            User::where('id','=',$request->supplier_id)->delete();//not working
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //WIP

        $image = $request->image;

        $supplier = Supplier::find($request->supplierID);

              
        $filename = $image->store('public/images');
                

        $img = Image::create([
            'path' => $filename
        ]);

        $img->supplier()->attach($supplier);
            
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // TODO - pedido PUT de /api/supplier/{id}

        $supplier = Supplier::find($id);
        
    
        $request->validate([
            'supplier_name' => 'required|string',
            'supplier_email' => 'required|string',
            'description' => 'required|string',
            'supplier_address' => 'required|string',
            'supplier_post_code' => 'required|string',
            'supplier_city' => 'required|string',
        ]);




        if($request->has('supplier_name')){
            $supplier->name = $request->input('supplier_name'); 
        }
        
        if($request->has('supplier_address')){
            $supplier->address = $request->input('supplier_address'); 
        }

        if($request->has('supplier_post_code')){
            $supplier->post_code = $request->input('supplier_post_code'); 
        }

        if($request->has('supplier_city')){
            $supplier->city = $request->input('supplier_city'); 
        }


        if($request->has('description')){
            $supplier->description = $request->input('description'); 
        }
        
        $user = User::find($id);

        if($request->has('supplier_email')){
            $user->email = $request->input('supplier_email'); 
        }

        // if($request->has('supplier_password')){
        //     $user->password = $request->input('supplier_password'); 
        // }
        
        $supplier->save();
        $user->save();
        
        return redirect(route('supplierProfile'  , ['id' => $id]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }


    public function create_coupon($id){

        if(!is_numeric($id)){
            return response('Invalid ID', 404);
        }

        $supplier = Supplier::find($id);
    
        //$this->authorize('view', $supplier);

        $data = [
                    'title' => 'Create Coupon',
                    'path' => '/api/coupon'        
                ];

        return view('pages.supplier.create_edit_coupon', $data);
    }
}
