<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Prices;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function get_list(Request $request){
        $token = $request->token;
        $catalog = Prices::all(['article', 'name', 'price_0', 'price_1', 'price_2', 'price_3', 'price_4', 'price_5']);
        return $catalog;
    }
}
