<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'acount_nm', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'S001';
    protected $primaryKey='accout_id';
    // public $timestamps=false;
    public $incrementing = false;
    const CREATED_AT = 'cre_date';
    const UPDATED_AT = 'upd_date';
}
