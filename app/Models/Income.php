<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'Incomes';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    public function Customer()
    {
      return $this->belongsTo('App\Models\Customer', 'CustomerId');
    }
}
