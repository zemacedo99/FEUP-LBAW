<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class UploadController extends Controller
{
    function index(Request $req)
    {
        return $req->file('file')->store('public/images');
    }

    public function save(Request $request)
    {
         
        $validatedData = $request->validate([
         'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
 
        ]);
 
        $name = $request->file('image')->getClientOriginalName();
 
        $path = $request->file('image')->store('public/images');
 
 
        $save = new Image;
 
        $save->name = $name;
        $save->path = $path;
 
        $save->save();
 
        return "saved";
 
    }
}
