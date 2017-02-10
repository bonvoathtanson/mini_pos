<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAsk extends Model
{
    protected $table = 'CustomerAsks';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    public static function rules()
    {
        $rules = array(
            'CustomerId'    => 'required',
            'AskDate'       => 'required',
            'Description'   => 'required',
            'ConfirmDate'   => 'required'
        );

        return $rules;
    }

    public function Customer()
    {
        return $this->belongsTo('App\Models\Customer', 'CustomerId');
    }

    const CANCEL = 0;

    const WAITING = 1;

    const SUCCESS = 2;
}
