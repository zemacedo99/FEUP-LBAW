<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Supplier;
use Illuminate\Http\Request;
use \Illuminate\Pagination\Paginator;
use \Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function paginate($items, $perPage = 8, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        //$items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_index(Request $request)
    {
        if(auth()->user()==null||!auth()->user()->is_admin){
            return abort(404, 'Page does not exist');
        }
        
        $users=User::all();
        $search=$request->search;
        if($search!=null){        
            $users=$users->whereRaw('search @@ to_tsquery(\'english\', ?)', [$search])
            ->orderByRaw('ts_rank(search, to_tsquery(\'english\', ?)) DESC', [$search]);
        }
        $usersFinal=[];

        foreach ($users as $user){
            // $temp=Client::where('id','=',$user->id)->get();
            $temp=Client::find($user->id);
            if ($temp===null){

                $temp=Supplier::find($user->id);
            }
            if ($temp===null){
                $temp=$user;
                $temp->name="ADMINISTRATOR ACCOUNT";
            }
            array_push($usersFinal,$temp);
        }

        $final=$this->paginate(collect($usersFinal));
        return view('pages.admin.users',['users'=>$final]);

    }

    public function getProfile($id){
        $temp=Client::find($id);

        if ($temp===null){
            return app('App\Http\Controllers\SupplierController')->show($id);
        }else{
            return app('App\Http\Controllers\ClientController')->show($id);
        }
    }

    public function admin_dashboard(){
        if(auth()->user()==null||!auth()->user()->is_admin){
            return abort(404, 'Page does not exist');
        }
        return view('pages.admin.dashboard');
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
        // TODO Where I left off: Em principio recebe os dados por aqui e decide se cria client ou supplier + user, por ORM ou DB::transaction
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
