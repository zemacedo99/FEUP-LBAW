<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function create(Request $request, Client $client)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:items,id',
            'rating' => 'required|integer|gte:1|lte:5',
            'description' => 'required|string'
        ]);

        $client_id = Auth::id();
        $item_id = $request->input('item_id');
        $rating = $request->input('rating');
        $description = $request->input('description');
            
        
        //Authorization
        if(!$this->boughtItem($client->purchases, $item_id)) return abort(403, 'You need to buy the item first' );


        
        Review::where('client_id', $client_id)->where('item_id', $item_id)->delete();
        
        $review = Review::create([
            'client_id' => $client_id,
            'item_id' => $item_id,
            'rating' => $rating,
            'description' => $description,
        ]);
            
        return $review;
    }


    /**
     * Verifies if the client bought the item
     */
    private function boughtItem($purchases, $item_id){
        foreach ($purchases as $purchase){
            foreach ($purchase->items as $item){
                if($item->id == $item_id){
                    if($purchase->status == 'Paid'){
                        return true;
                    }else{
                        return false;
                    }       
                }
            }
        }
        return false;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Client $client)
    {

        $request->validate([
            'item_id' => 'required|integer|exists:items,id',
        ]);

        $client_id = Auth::id();
        $item_id = $request->input('item_id');

        $builder = Review::where('client_id', $client_id)->where('item_id', $item_id);
        
        //Authorization
        $this->authorize('delete', $builder->first());
        
        $builder->delete();
        

        return response('Review deleted', 204);
        
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
            return abort(404, 'Review not found');
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
