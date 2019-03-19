<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    protected $table = 'price';

    protected $fillable = ['article', 'name', 'price_0', 'price_1', 'price_2', 'price_3', 'price_4', 'price_5', 'price_6', 'qty', 'data'];
}
