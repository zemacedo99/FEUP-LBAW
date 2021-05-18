<?php

namespace App\Http\Controllers;

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
        return view('pages.misc.products_list', ['suppliers' => $suppliers]);
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
        if ($request->accept=="1"){
            Supplier::where('id','=',$request->supplier_id)->update(['accepted'=>"true"]);
        }else{
            //return Supplier::where('id','=',$request->supplier_id)->get();
            Supplier::find('id','=',$request->supplier_id)->delete();//not working
            //User::where('id','=',$request->supplier_id)->delete();//not working
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
    public function destroy(Supplier $supplier)
    {
        //
    }
}
