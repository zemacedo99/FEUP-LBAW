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
        $suppliers = Supplier::get();

        $all = [];
        $i = 0;
        foreach($suppliers as $supplier)
        {
            
            $image = Image::find($supplier->image_id);
            $all[$i] = [$supplier,$image];
            
            
            $i++;
        }

        $data =
        [
            'suppliers' => $all,

        ];

        return view('pages.misc.products_list',$data);
    }


    public function allProducts($id)
    {
        $supplier = Supplier::find($id);

        $image = Image::find($supplier->image_id);
        $items = Item::where('supplier_id', '=', $id)->get();


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
            'name' => $supplier->name,
            'items' => $all,
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
        $items = Item::where('supplier_id', '=', $id)->where('active','=','true')->get();

        $all = [];
        $stars = 0;

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
            
            $stars = $stars + $item->rating;
            $i++;
        }

        $stars = $stars / $i;


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
            'items' => $all,
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

        $items =  $supplier->items()->where('active','=','true')->get();
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
            return response('', 404)->header('description','Page does not exist');
        }

        $suppliers=Supplier::where('accepted', 'false')->paginate(8);

        return view('pages.admin.requests',['suppliers'=>$suppliers]);
    }

    public function requestHandling(Request $request){
        $supplier=Supplier::find($request->supplier_id);
        if ($request->accept=="1"){
            return $supplier->update(['accepted'=>"true"]);
        }else if ($request->accept=="0"){
            return $this->delete($supplier);
        }else{
            return response('', 500)->header('description','Invalid request parametrization');
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
    public function update(Request $request, Supplier $supplier)
    {
        // TODO - pedido PUT de /api/supplier/{id}
        abort(501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function delete(Supplier $supplier)
    {
        //$this->authorize('delete',$supplier);
        
        $supplier->delete();//todo if on update cascade works this is unnecessary
        return User::find($supplier->id)->delete();
        //
    }


    public function create_coupon($id){
    
        $this->authorize('view', Supplier::find($id));
        $data = [
                    'title' => 'Create Coupon',
                    'path' => '/api/coupon'        
                ];

        return view('pages.supplier.create_edit_coupon', $data);
    }
}
