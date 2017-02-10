<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'Users';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Name', 'Email', 'Password','DateCreated'
    ];

    protected $hidden = [
        'Password', 'remember_token',
    ];

    public function getAuthPassword() {
        return $this->Password;
    }

    public function getRememberToken()
    {
        return '';
    }

    public function setRememberToken($value)
    {

    }

    public function getRememberTokenName()
    {
        return 'trash_attribute';
    }

    public static function rules(){
        $rules = array(
            'Name'      => 'required|unique:Users',
            'Email'     => 'required|email|unique:Users',
            'Password'  => 'required|max:6'
        );

        return $rules;
    }
}
