<?php

namespace App\Http\Controllers\API;

use App\Clients;
use App\Http\Controllers\Controller;
use App\Prices;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function get_list(Request $request){
        $token = $request->token;
        $token_1 =  date('Y-m-d').'modern-it.ru';
        $username = $request->username;
/*        if ($token != md5(date('Y-m-d').'modern-it.ru')){
            die('Autorization error');
        }*/
        $price_level = $this->getPriceLevel($username);
        $catalog = Prices::all(['article', 'name', 'price_'.$price_level]);
        return $catalog;
    }

    public function get_articles(Request $request){
        $articles = json_decode($request->articles, true);
        $username = $request->username;
        $price_level = $this->getPriceLevel($username);
        $catalog = Prices::select('article', 'name', 'price_'.$price_level.' as price')->
            whereIn('article', $articles)->get();
        return $catalog;
    }

    private function getPriceLevel($username){
        $client = Clients::whereLogin($username)->first();
        if (!is_null($client)){
            $price_level = $client->price_level;
        } else {
            $price_level = 0;
        }
        return $price_level;
    }
}
