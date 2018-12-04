<?php

namespace App\Http\Controllers;

use App\Prices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
   public function import(){
       \App\Prices::truncate();

/*       $content = file_get_contents(storage_path('upload_price').'/price.csv');
       $fileD_utf = iconv('cp1251', 'utf8', $content);
       $f_wr = file_put_contents(storage_path('upload_price').'/price_utf.csv', $fileD_utf);*/

       $fileD = fopen(storage_path('upload_price').'/price.csv',"r");
       $column = fgetcsv($fileD);
       while(!feof($fileD)){
           $rowData[]=fgetcsv($fileD, 0,';');
       }
       foreach ($rowData as $key => $value) {

           $articul = trim($value[0]);
           $articul = iconv('cp1251', 'utf8', $articul);
           $articul = str_replace('М', 'M', $articul);
           $articul = str_replace(' ', '', $articul);
           $articul = str_replace('(', '-', $articul);
           $articul = str_replace(')', '', $articul);

           $unique = ImportController::unique($articul);

           if (!$unique){
               continue;
           }

           $inserted_data=[
               'article'=>$articul,
               'name'=>iconv('cp1251', 'utf8', $value[1]),
               'price_0'=>(int)$value[2],
               'price_1'=>(int)$value[3],
               'price_2'=>(int)$value[4],
               'price_3'=>(int)$value[5],
               'price_4'=>(int)$value[6],
               'price_5'=>(int)$value[7],
               'qty'=>(int)$value[8],
               'data'=>iconv('cp1251', 'utf8', $value[9])
           ];

           \App\Prices::create($inserted_data);
       }

       return view('upload')->with('status', 'Импорт завершен');
       die();
   }

   static function unique($article){
       $in_db = Prices::where('article', '=', $article)->count();
       if ($in_db > 0) {
           return false;
       } else {
           return true;
       }

   }
}
