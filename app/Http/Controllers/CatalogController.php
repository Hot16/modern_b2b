<?php
namespace App\Http\Controllers;

use App\Prices;

class CatalogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show (){
        $catalog = Prices::all(['article', 'name', 'price_0', 'price_1', 'price_2', 'price_3', 'price_4', 'price_5', 'price_6', 'qty']);
        return view('catalog', ['catalog'=>$catalog]);
    }
}
