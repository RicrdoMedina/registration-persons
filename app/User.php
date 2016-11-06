<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','nombre','apellido','password','rol','status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'rol','remember_token',
    ];

    public function setNamesAttribute($value)
    {
        $this->attributes['nombre'] = ucwords(strtolower($value));//ucwords — Convierte a mayúsculas el primer caracter de cada palabra de una cadena
    }

    public function setLastNamesAttribute($value)
    {
        $this->attributes['apellido'] = ucwords(strtolower($value));
    }

    public static function searchUser($id) 
    {
        return DB::table('users')
                 ->select('id','email', 'nombre','apellido','rol')
                 ->where('users.id', '=', $id)
                 ->get();
    }

    public static function listUsers() 
    {
        return DB::table('users')
                 ->select('id','email', 'nombre','apellido','rol','status')
                 ->orderBy('id', 'desc');
    }
}
