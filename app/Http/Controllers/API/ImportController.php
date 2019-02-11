<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\LogImport;
use App\Prices;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        $summary = ['total_str' => count($rowData),
            'total_imported' => 0,
            'doubled' => 0,
            'doubled_item' => []
            ];
        foreach ($rowData as $key => $value) {

            $articul = trim($value[0]);
            $articul = iconv('cp1251', 'utf8', $articul);
            $articul = str_replace('М', 'M', $articul);
            $articul = str_replace(' ', '', $articul);
            $articul = str_replace('(', '-', $articul);
            $articul = str_replace(')', '', $articul);

            $unique = ImportController::unique($articul);

            if (!$unique){
                $summary['doubled'] += 1;
                $summary['doubled_items'][] = $articul. ' '. iconv('cp1251', 'utf8', $value[1]);
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
            $summary['total_imported'] += 1;
            \App\Prices::create($inserted_data);
        }

        $fc = fclose($fileD);
        $fd = unlink(storage_path('upload_price').'/price.csv');
        $summary['file_close'] = $fc;
        $summary['file_delete'] = $fd;
        $user = auth()->user();
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
