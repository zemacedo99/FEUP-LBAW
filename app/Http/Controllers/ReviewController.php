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
        // Acho que é com get
        return Review::where('item_id', "=", $request->input("item_id"))->get();
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
    public function delete(Request $request, $id)
    {
        $review = Review::find($id);
        $this->authorize('delete', $review);
        $review->delete();
        return $review;
        //
    }
}
