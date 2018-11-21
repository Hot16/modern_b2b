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
        $users = User::all(['name', 'email']);
        return view('users')->with('users');
    }
}
