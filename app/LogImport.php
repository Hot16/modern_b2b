<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 11.02.19
 * Time: 23:07
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class LogImport extends Model
{
    protected $table = 'log_import';

    protected $fillable = ['id_user', 'log'];
}