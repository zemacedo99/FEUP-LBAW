<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews of a product.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        #$this->authorize('view');//TODO
        // Acho que é com get
        $request->validate([
            'item_id' => 'required|integer',
        ]);
        return Review::where('item_id', "=", $request->input("item_id"))->get();
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

     
        $request->validate([
            'client_id' => 'required|integer',
            'item_id' => 'required|integer',
            'rating' => 'required|integer',
            'description' => 'required|string'
        ]);


        $this->authorize('create', $item_id);
   

        $review = Review::create([
            'client_id' => $request->input('client_id'),
            'item_id' => $request->input('item_id'),
            'rating' => $request->input('rating'),
            'description' => $request->input('description'),
        ]);

        return $review;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {

        // return Auth::check();
        // return ($this->authorize('delete'));

        $request->validate([
            'client_id' => 'required|integer',
            'item_id' => 'required|integer'
        ]);

        $review = Review::where('client_id','=',$request->input('client_id'))->where('item_id','=',$request->input('item_id'))->delete();

        
        return $review;//this returns 0 or 1 true or false
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   //Testado!
        
        $request->validate([
            'client_id' => 'required|integer',
            'item_id' => 'required|integer'
        ]);

        
        $review_collection = Review::where('client_id', '=', $request->input('client_id'))->where('item_id','=',$request->input('item_id'))->get();
        
        $this->authorize('update', $review_collection);
        
        if($review_collection->isEmpty()){
            return response('', 404)->header('description','Review not found');
        }

        $review=$review_collection->first();

        if($request->has('rating')){
            $review->rating = $request->input('rating'); 
        }

        if($request->has('description')){
            $review->description = $request->input('description'); 
        }

        
        
        $review->save();
        
        return response('', 204,)->header('description', 'Successfully updated review');
    }

}
