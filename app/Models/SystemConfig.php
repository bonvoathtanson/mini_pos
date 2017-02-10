<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    protected $table = 'SystemConfigs';

    protected $primaryKey = 'Id';

    public $timestamps = false;
}
