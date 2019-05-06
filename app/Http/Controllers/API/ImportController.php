<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\LogImport;
use App\Prices;
use App\User;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function import(){
        /*\App\Prices::truncate();

               $content = file_get_contents(storage_path('upload_price').'/price.csv');
               $fileD_utf = iconv('cp1251', 'utf8', $content);
               $f_wr = file_put_contents(storage_path('upload_price').'/price_utf.csv', $fileD_utf);*/

        if (!file_exists(storage_path('upload_price').'/price.csv')){
            return ['status' => 'Файл не найден'];
        }
	    \App\Prices::truncate();
        $fileD = fopen(storage_path('upload_price').'/price.csv',"r");

        $column = fgetcsv($fileD);
        while(!feof($fileD)){
            $rowData[]=fgetcsv($fileD, 0,';');
        }

        $summary = ['total_str' => count($rowData),
            'total_imported' => 0,
            'not_articul' => 0,
            'not_price' => 0,
            'doubled' => 0,
            'doubled_item' => []
            ];
        foreach ($rowData as $key => $value) {

            $articul = trim($value[0]);
            if ($articul == ''){
                $summary['not_articul'] += 1;
                continue;
            }
           // $articul = mb_convert_encoding($articul, 'cp1251', 'utf8');
            $articul = str_replace('М', 'M', $articul);
            $articul = str_replace(' ', '', $articul);
            $articul = str_replace('(', '-', $articul);
            $articul = str_replace(')', '', $articul);

            $unique = ImportController::unique($articul);

            if (!$unique){
                $summary['doubled'] += 1;
                $summary['doubled_items'][] = $articul. ' '. $value[1];
                continue;
            }

            foreach (range(1,10) as $i){
                if (!isset($value[$i])){
                    $value[$i] = null;
                }
                $value[$i] = trim($value[$i]);
            }

            if ($value[9] == '' ){
                $value[9] = '1';
            }

            $inserted_data=[
                'article'=>$articul,
                'name'=> $value[1],
                'price_0'=>(int)$value[2],
                'price_1'=>(int)$value[3],
                'price_2'=>(int)$value[4],
                'price_3'=>(int)$value[5],
                'price_4'=>(int)$value[6],
                'price_5'=>(int)$value[7],
                'price_6'=>(int)$value[8],
                'qty'=>(int)$value[9],
                'data'=>$value[10]
            ];
            $not_price = true;
            foreach (range(0, 6) as $j){
                if ($inserted_data['price_'.$j] !== 0){
                    $not_price = false;
                }
            }
            if ($not_price){
                $summary['not_price'] += 1;
                continue;
            }
            $summary['total_imported'] += 1;
            \App\Prices::create($inserted_data);
        }

        $fc = fclose($fileD);
        $fd = unlink(storage_path('upload_price').'/price.csv');
        $summary['file_close'] = $fc;
        $summary['file_delete'] = $fd;
        $user = auth()->user();
        if (is_null($user)){
            $user = User::where('name' , '=', 'System')->first();
        }
        LogImport::create([
            'id_user'=>$user->id,
            'log'=>json_encode($summary)
            ]);
        $resp = ['status'=>'Импорт завершен',
            'summary' => $summary];
        return $resp;
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
