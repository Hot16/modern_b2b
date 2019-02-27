<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(){
        $users_m = User::all(['id','name', 'email'])->where('id', '<>', 3);
        return view('users', ['users'=>$users_m]);
    }

    public function delete($id){
        $d = User::where('id', '=', $id)->delete();
        $users_m = User::all(['id','name', 'email']);
        return view('users', ['users'=>$users_m]);
    }
}
