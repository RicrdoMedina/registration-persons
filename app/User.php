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

    public static function filterUsers($type_user,$value) 
    {
        return DB::table('users')
                ->select('id','email', 'nombre','apellido','rol','status')
                 ->where('users.rol', '=', $type_user)
                 ->where(function ($query) use ($value) {
                    $query->where('users.nombre', 'LIKE', '%'.$value.'%')
                    ->orWhere('users.apellido', 'LIKE', '%'.$value.'%')
                    ->orWhere('users.email', 'LIKE', '%'.$value.'%')
                    ->orWhere('users.status', 'LIKE', '%'.$value.'%');
                 })
                 ->orderBy('users.id', 'desc');
    }

    public static function searchUsersForDate($type_user,$date_start,$date_end,$value) 
    {
        return DB::table('users')
                 ->select('id','email', 'nombre','apellido','rol','status')
                 ->where('users.rol', '=', $type_user)
                 ->whereBetween('users.created_at',[$date_start,$date_end])
                 ->where(function ($query) use ($value) {
                    $query->where('users.nombre', 'LIKE', '%'.$value.'%')
                    ->orWhere('users.apellido', 'LIKE', '%'.$value.'%')
                    ->orWhere('users.email', 'LIKE', '%'.$value.'%')
                    ->orWhere('users.status', 'LIKE', '%'.$value.'%');
                 })
                ->orderBy('users.id', 'desc');
    }
}
