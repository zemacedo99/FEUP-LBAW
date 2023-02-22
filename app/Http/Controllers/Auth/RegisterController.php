<?php

namespace App\Http\Controllers\Auth;

use App\Models\Client;
use App\Models\Supplier;
use App\Models\User;
use App\Http\Controllers\Controller;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'exclude_if:type,client|required|string',
            'post-code' => 'exclude_if:type,client|required|string',
            'city' => 'exclude_if:type,client|required|string',
            'description' => 'exclude_if:type,client|required|string',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     * @throws \Exception
     */
    protected function create(array $data)
    {
        DB::beginTransaction();

        try {
            $newUser = User::create([
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
        } catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }

        if (strcmp($data['type'], "client") == 0){
            try {
                Client::create([
                    'id' => $newUser->id,
                    'name' => $data['name'],
                ]);
            } catch (ValidationException $e) {
                DB::rollBack();
            } catch (\Exception $e){
                DB::rollBack();
                throw $e;
            }
        } elseif (strcmp($data['type'], "supplier") == 0){
            try {
                Supplier::create([
                    'id' => $newUser->id,
                    'name' => $data['name'],
                    'address' => $data['address'],
                    'post_code' => $data['post-code'],
                    'city' => $data['city'],
                    'description' => $data['description'],
                ]);
            } catch (ValidationException $e) {
                DB::rollBack();
            } catch (\Exception $e){
                DB::rollBack();
                throw $e;
            }
        }

        DB::commit();
        return $newUser;
    }

}
