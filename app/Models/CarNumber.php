<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarNumber extends Model
{
    protected $table = 'CarNumbers';
    
    protected $primaryKey = 'Id';

    public $timestamps = false;
}
