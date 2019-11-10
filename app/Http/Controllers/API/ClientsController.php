<?php
namespace App\Http\Controllers\API;


use App\Clients;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
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

        $toModern = $this->sendToModernit($request);
        if ($toModern != 'ok'){
            return ['status' => 'not',
                'status_msg'=>$toModern];
        }

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

        $resp = ['status'=>'ok',
            'status_msg' => 'Сохранили'];
        return $resp;
    }

    public function delete(Request $request){
        Clients::where('id', '=', $request->id)->delete();
        $resp = ['status'=>'Удалили'];
        return $resp;
    }

    public function sendToModernit($request){
        $name = $request->name;
        $login = $request->login;
        $email = $request->email;
        $password = $request->password;
        $action = $request->action;
        $data = [
            'name' => $name,
            'username' => $login,
            'email' => $email,
            'action' => $action,
            'in' => md5($password),
             'token' => md5('b2b.modern'.date('Y-m-d'))
        ];
        $ch = curl_init('https://www.modern-it.ru/external_api/CreateUser.php?XDEBUG_SESSION_START');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        curl_close($ch);

        return $result;


    }

}
