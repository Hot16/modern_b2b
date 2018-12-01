<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(){
        $clients = Clients::all(['id', 'name', 'login', 'email', 'price_level']);
        return view('clients.clients', ['clients'=>$clients]);
    }

    public function edit(){

    }

    public function create(Request $request){
        $name = $request->name;
        $login = $request->login;
        $email = $request->email;
        $price_level = $request->price_level;

        Clients::insert(
            [
                'name' => $name,
                'login' => $login,
                'email' => $email,
                'price_level' => $price_level
            ]
        );

        return redirect(route('clients_show'));



    }

    public function delete(){

    }
}
