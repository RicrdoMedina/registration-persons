<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;


class Guest extends Model
{
    protected $table = 'guests';

    public $primaryKey='id';

    protected $fillable = ['cedula','names', 'lastNames','photo_src','id_type_guest'];

    public function setNamesAttribute($value)
    {
        $this->attributes['names'] = ucwords(strtolower($value));//ucwords — Convierte a mayúsculas el primer caracter de cada palabra de una cadena
    }

    public function setLastNamesAttribute($value)
    {
        $this->attributes['lastNames'] = ucwords(strtolower($value));
    }

    public function enterprises()
    {
        //return $this->belongsToMany('miproyecto\Enterprise','enterprise_guest','guest_id','enterprise_id')->withPivot('enterprise_other');

        return $this->belongsToMany('miproyecto\Enterprise')->withPivot('enterpriseOther');
    }

    public static function searchGuest($id) 
    {
        return DB::table('guests')
                 ->leftJoin('enterprise_guest', 'guests.id', '=', 'enterprise_guest.guest_id')
                 ->leftJoin('enterprises', 'enterprise_guest.enterprise_id', '=', 'enterprises.id_enterprise')
                 ->select('enterprise_guest.enterpriseOther', 'enterprises.enterprise','guests.*')
                 ->where('guests.cedula', '=', $id)
                 ->get();
    }

    public static function listGuests() 
    {
        return DB::table('guests')
                 ->leftJoin('enterprise_guest', 'guests.id', '=', 'enterprise_guest.guest_id')
                 ->leftJoin('enterprises', 'enterprise_guest.enterprise_id', '=', 'enterprises.id_enterprise')
                 ->select('enterprise_guest.*', 'enterprises.*','guests.*')
                 ->orderBy('id', 'desc');
    }

    public static function searchGuests($type_user,$value) 
    {
        return DB::table('guests')
                 ->leftJoin('enterprise_guest', 'guests.id', '=', 'enterprise_guest.guest_id')
                 ->leftJoin('enterprises', 'enterprise_guest.enterprise_id', '=', 'enterprises.id_enterprise')
                 ->select('enterprise_guest.*', 'enterprises.*','guests.*')
                 ->where('guests.id_type_guest', '=', $type_user)
                 ->where(function ($query) use ($value) {
                     $query->where('guests.names', 'LIKE', '%'.$value.'%')
                     ->orWhere('guests.lastNames', 'LIKE', '%'.$value.'%')
                     ->orWhere('guests.cedula', 'like', '%'.$value.'%')
                     ->orWhere('enterprises.enterprise', 'LIKE', '%'.$value.'%')
                     ->orWhere('enterprise_guest.enterpriseOther', 'LIKE', '%'.$value.'%');
                 });
    }

    public static function searchGuestsForDate($type_user,$date_start,$date_end,$value) 
    {
        return DB::table('guests')
                 ->leftJoin('enterprise_guest', 'guests.id', '=', 'enterprise_guest.guest_id')
                 ->leftJoin('enterprises', 'enterprise_guest.enterprise_id', '=', 'enterprises.id_enterprise')
                 ->select('enterprise_guest.*', 'enterprises.*','guests.*')
                 ->where('guests.id_type_guest', '=', $type_user)
                 ->whereBetween('guests.created_at',[$date_start,$date_end])
                 ->where(function ($query) use ($value) {
                     $query->where('guests.names', 'LIKE', '%'.$value.'%')
                     ->orWhere('guests.lastNames', 'LIKE', '%'.$value.'%')
                     ->orWhere('guests.cedula', 'like', '%'.$value.'%')
                     ->orWhere('enterprises.enterprise', 'LIKE', '%'.$value.'%')
                     ->orWhere('enterprise_guest.enterpriseOther', 'LIKE', '%'.$value.'%');
                 });
    }

    public static function listVisits($id) 
    {
        return DB::table('guests')
                 ->leftJoin('description_visits', 'guests.id', '=', 'description_visits.id_guest_description')
                 ->leftJoin('destinations', 'description_visits.id_destination', '=', 'destinations.id')
                 ->leftJoin('type_visits', 'description_visits.id_type_visit', '=', 'type_visits.id')
                 ->leftJoin('motive_visits', 'description_visits.id_motive', '=', 'motive_visits.id')
                 ->select('description_visits.*', 'destinations.destination', 'type_visits.type_visit','motive_visits.motive_visit')
                 ->where('guests.id', '=', $id)
                 ->orderBy('description_visits.id_description_visits', 'desc');
    }

    public static function searchVisit($id,$value) 
    {
        return DB::table('guests')
                 ->leftJoin('description_visits', 'guests.id', '=', 'description_visits.id_guest_description')
                 ->leftJoin('destinations', 'description_visits.id_destination', '=', 'destinations.id')
                 ->leftJoin('type_visits', 'description_visits.id_type_visit', '=', 'type_visits.id')
                 ->leftJoin('motive_visits', 'description_visits.id_motive', '=', 'motive_visits.id')
                 ->select('description_visits.*', 'destinations.destination', 'type_visits.type_visit','motive_visits.motive_visit')
                 ->where('guests.id', '=', $id)
                 ->where(function ($query) use ($value) {
                     $query->where('description_visits.created_at', 'LIKE', '%'.$value.'%')
                     ->orWhere('description_visits.motiveOther', 'LIKE', '%'.$value.'%')
                     ->orWhere('destinations.destination', 'LIKE', '%'.$value.'%')
                     ->orWhere('type_visits.type_visit', 'like', '%'.$value.'%')
                     ->orWhere('motive_visits.motive_visit', 'LIKE', '%'.$value.'%');
                 });
    }

    public static function searchVisitForDate($id,$date_start,$date_end,$value)
    {
        return DB::table('guests')
                 ->leftJoin('description_visits', 'guests.id', '=', 'description_visits.id_guest_description')
                 ->leftJoin('destinations', 'description_visits.id_destination', '=', 'destinations.id')
                 ->leftJoin('type_visits', 'description_visits.id_type_visit', '=', 'type_visits.id')
                 ->leftJoin('motive_visits', 'description_visits.id_motive', '=', 'motive_visits.id')
                 ->select('description_visits.*', 'destinations.destination', 'type_visits.type_visit','motive_visits.motive_visit')
                 ->where('guests.id', '=', $id)
                 ->whereBetween('description_visits.created_at',[$date_start,$date_end])
                 ->where(function ($query) use ($value) {
                     $query->where('description_visits.created_at', 'LIKE', '%'.$value.'%')
                     ->orWhere('description_visits.motiveOther', 'LIKE', '%'.$value.'%')
                     ->orWhere('destinations.destination', 'LIKE', '%'.$value.'%')
                     ->orWhere('type_visits.type_visit', 'like', '%'.$value.'%')
                     ->orWhere('motive_visits.motive_visit', 'LIKE', '%'.$value.'%');
                 });
    }


    public function scopeCedula($query, $id)
    {
    	//$query->where('cedula', 'LIKE', '%'.$cedula.'%');

    	/*$query->where(function ($query) use ($id) {
             $query->where('cedula', 'LIKE', '%'.$id.'%')
                   ->orWhere('names', 'LIKE', '%'.$id.'%')
                   ->orWhere('last_names', 'LIKE', '%'.$id.'%');

        
       });*/
    }
}
