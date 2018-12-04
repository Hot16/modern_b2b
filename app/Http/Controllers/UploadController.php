<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('upload');
    }

    public function upload(Request $request){
        $request->validate([

            'price' => 'required',

        ]);

/*        $validator = \Validator::make($request->all(), [
            'price' => 'required|mimes:csv',
        ]);*/
        $fileName = 'price.'.$request->price->getClientOriginalExtension();



        $request->price->move(storage_path('upload_price'), $fileName);



        return back()

            ->with('status','Файл загружен')

            ->with('price',$fileName);
    }
}
