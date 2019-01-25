<?php
namespace App\Http\Controllers\API;


use App\Clients;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(){
        $clients = Clients::all(['id', 'name', 'login', 'email', 'price_level']);
        return $clients;
    }

    public function getClient(Request $request){
        $client = Clients::where('id', '=', $request->id)->get();
        return $client;
    }

    public function create(Request $request){
        $id = $request->id;
        $name = $request->name;
        $login = $request->login;
        $email = $request->email;
        $price_level = $request->price_level;

        if (is_null($price_level)){
            $price_level = 0;
        }

        if (!is_null($id)){
            Clients::where('id', '=', $request->id)->update(['name' => $name, 'login' => $login, 'email' => $email, 'price_level' => $price_level]);
        } else {
            Clients::insert(
                [
                    'name' => $name,
                    'login' => $login,
                    'email' => $email,
                    'price_level' => $price_level
                ]
            );
        }

        $resp = ['status'=>'Сохранили'];
        return $resp;
    }

    public function delete(Request $request){
        Clients::where('id', '=', $request->id)->delete();
        $resp = ['status'=>'Удалили'];
        return $resp;
    }

}