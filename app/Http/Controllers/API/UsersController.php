<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 21.01.19
 * Time: 23:37
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(){
        $users_m = User::all(['id','name', 'email']);
        return view('users', ['users'=>$users_m]);
    }

    public function delete($id){
        $d = User::where('id', '=', $id)->delete();
        $users_m = User::all(['id','name', 'email']);
        return view('users', ['users'=>$users_m]);
    }

}