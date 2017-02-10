<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expanse extends Model
{
    protected $table = 'Expanses';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    public function Supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'SupplierId');
    }
}
