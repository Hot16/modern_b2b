<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Prices;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request){
        $request->validate([

            'price' => 'required',

        ]);

        /*        $validator = \Validator::make($request->all(), [
                    'price' => 'required|mimes:csv',
                ]);*/
        $fileName = 'price.'.$request->price->getClientOriginalExtension();



        $request->price->move(storage_path('upload_price'), $fileName);



        return 'Загрузка завершена';
    }
}