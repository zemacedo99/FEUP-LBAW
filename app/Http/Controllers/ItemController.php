<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::all();
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Item::where('id', '=', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'item.description' => 'string',
            'item.quantityAvailable' => 'integer',
            'item.price' => 'numeric',
            'item.unit' => 'string'
        ]);

        if(!is_numeric($id)){
            return response('', 404)->header('description','The item was not found');
        }

        $item = Item::where('id', '=', $id)->get();
        if($item->isEmpty()){
            return response('', 404)->header('description','The item was not found');
        }

        $item_data = $item->first();

        if($request->has('item.description')){
            $item_data->description = $request->input('item.description'); 
        }

        if($request->has('item.quantityAvailable')){
            $item_data->stock = $request->input('item.quantityAvailable'); 
        }

        if($request->has('item.price')){
            $item_data->price = $request->input('item.price'); 
        }

        if($request->has('item.unit')){
            $item_data->unit = $request->input('item.unit'); 
        }

        $item_data->save();

        return response('', 204,)->header('description', 'Successfully updated item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!is_numeric($id)){
            return response('', 404)->header('description','The item was not found');
        }

        $item = Item::where('id', '=', $id)->get();
        if($item->isEmpty()){
            return response('', 404)->header('description','The item was not found');
        }

        $item_data = $item->first();

        $item_data->active = 'false';
    
        $item_data->save();

        return response('', 204,)->header('description', 'Successfully deactivated item');
    }
}
