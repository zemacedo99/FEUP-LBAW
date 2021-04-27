<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::all();
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
            'client.email' => 'required|string',
            'client.password' => 'required|string',
            'client.name' => 'required|string',
            'client.image_id' => 'required|integer'
        ]);
        
        $user = User::create([
            'email' => $request->input('client.email'),
            'password' => $request->input('client.password')        
        ]);

        Client::create([
            'id' => $user->id,
            'name' => $request->input('client.name'),
            'image_id' => $request->input('client.image_id')        
        ]);

        return response('', 204)->header('description', 'Successfully created the client');
    }

    /**
     * Display the spePified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   

        $client = Client::find($id);
        
        $name = $client->name;
        $image_id = $client->image_id;

        

        return view('pages.client.client_profile',['name' => $name ]);


    }

    public function get_info($id)
    {
        //Merge não está a funcionar nao sei pq 
        // $client = Client::where('id', '=', $id)->get();
        // $user = User::where('id', '=', $id)->get();

        // $merged = $client->merge($user); 

        // return $merged;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   // Testado!
        $request->validate([
            'client.email' => 'string',
            'client.password' => 'string',
            'client.name' => 'string',
            'client.image_id' => 'integer'
        ]);

        if(!is_numeric($id)){
            return response('', 404)->header('description','The client was not found');
        }

        $client = Client::where('id', '=', $id)->get();
        $user = User::where('id', '=', $id)->get();
        
        
        if($client->isEmpty()){
            return response('', 404)->header('description','The client was not found');
        }

        $client_data = $client->first();
        $user_data = $user->first();

        if($request->has('client.email')){
            $user_data->email = $request->input('client.email'); 
        }

        if($request->has('client.password')){
            $user_data->password = $request->input('client.password'); 
        }

        if($request->has('client.name')){
            $client_data->name = $request->input('client.name'); 
        }

        if($request->has('client.image_id')){
            $client_data->image_id = $request->input('client.image_id'); 
        }

        $user_data->save();
        $client_data->save();
        
        return response('', 204,)->header('description', 'Successfully updated client information');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   //postgres não deixa apagar
        $client = Client::where('id', '=', $id);
        $user = User::where('id', '=', $id);
        
        if($client->get()->isEmpty() || $user->get()->isEmpty()){
            return response('', 404,)->header('description', 'Client not found');
        }

        $client->delete();
        $user-> delete();

        return response('', 204,)->header('description', 'Successfully deleted the client');
    }
}
