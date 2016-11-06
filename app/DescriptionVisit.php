<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class DescriptionVisit extends Model
{
    protected $table = 'description_visits';

    public $primaryKey='id_description_visits';

    protected $fillable = ['id_guest_description','id_destination', 'id_motive','id_type_guest','id_type_visit','motiveOther'];

    public function setMotiveOtherAttribute($value)
    {
        $this->attributes['motiveOther'] = ucfirst($value);
    }

    // public function setCreated_atAttribute($value)
    // {
    //     $this->attributes['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d-m-Y H:i:s');
    // }

    public static function getLastVisit($value)
    {
        /*$dt = Carbon::now('America/Caracas');
        setlocale(LC_ALL,"es","es_ES","esp"); 
        
        return $dt::createFromFormat('Y-m-d H:i:s', $date)->formatLocalized('%d de %B del %Y a las %H:%M:%S %p'); 

        $dt = Carbon::createFromDate(2016, 1, 14, 'America/Caracas');
        $dt::setlocale("es"); 

        return $dt->diffForHumans(); */

        $porciones = explode("-", $value);
        $y = $porciones[0]; // Año
        $m = $porciones[1]; // Mes
        $dia_hora = $porciones[2]; // Dia y hora

        $porciones = explode(" ", $dia_hora);
        $d = $porciones[0]; // Dia

        $dt = Carbon::createFromDate($y,$m,$d, 'America/Caracas');
        $dt::setlocale("es"); 

        return $dt->diffForHumans();

    }

    //PARA ELOQUENT
    /*public function getCreatedAtAttribute($date)
    {
        $dt = Carbon::now('America/Caracas');
        setlocale(LC_ALL,"es","es_ES","esp"); 

        return $dt::createFromFormat('Y-m-d H:i:s', $date)->formatLocalized('%d de %B del %Y a las %H:%M:%S %p'); 


        $dt = Carbon::createFromDate(2016, 1, 14, 'America/Caracas');
       $dt::setlocale("es"); 
       echo $dt->diffForHumans(); 
    }*/

    public static function formatDate($value)
    {
        $dt = Carbon::now('America/Caracas');
        //setlocale(LC_ALL,"es","es_ES","esp");
        setlocale(LC_TIME, 'es_ES.UTF-8');
        
        return $dt::createFromFormat('Y-m-d H:i:s', $value)->formatLocalized('%d de %B del %Y a las %H:%M:%S %p'); 
    }

    public static function listVisits() 
    {
        return DB::table('description_visits')
                 ->leftJoin('destinations', 'description_visits.id_destination', '=', 'destinations.id')
                 ->leftJoin('type_visits', 'description_visits.id_type_visit', '=', 'type_visits.id')
                 ->leftJoin('motive_visits', 'description_visits.id_motive', '=', 'motive_visits.id')
                 ->leftJoin('guests', 'description_visits.id_guest_description', '=', 'guests.id')
                 ->select('description_visits.*', 'destinations.destination', 'type_visits.type_visit','motive_visits.motive_visit','guests.id','guests.cedula','guests.names','guests.lastNames','guests.photo_src','guests.id_type_guest')
                 ->orderBy('description_visits.id_description_visits', 'desc');
    }

    public static function searchVisits($type_user,$value) 
    {
        return DB::table('description_visits')
                 ->leftJoin('destinations', 'description_visits.id_destination', '=', 'destinations.id')
                 ->leftJoin('type_visits', 'description_visits.id_type_visit', '=', 'type_visits.id')
                 ->leftJoin('motive_visits', 'description_visits.id_motive', '=', 'motive_visits.id')
                 ->leftJoin('guests', 'description_visits.id_guest_description', '=', 'guests.id')
                 ->select('destinations.destination', 'type_visits.type_visit','motive_visits.id','guests.id','guests.cedula','guests.names','guests.lastNames','guests.photo_src','guests.id_type_guest','description_visits.*')
                 ->where('guests.id_type_guest', '=', $type_user)
                 ->where(function ($query) use ($value) {
                    $query->where('guests.names', 'LIKE', '%'.$value.'%')
                    ->orWhere('guests.lastNames', 'LIKE', '%'.$value.'%')
                    ->orWhere('description_visits.motiveOther', 'LIKE', '%'.$value.'%')
                    ->orWhere('destinations.destination', 'LIKE', '%'.$value.'%')
                    //->orWhere('type_visits.type_visit', 'like', '%'.$value.'%')
                    ->orWhere('motive_visits.motive_visit', 'LIKE', '%'.$value.'%');
                 })
                 ->orderBy('description_visits.id_description_visits', 'desc');
    }

    public static function searchVisitsForDate($type_user,$date_start,$date_end,$value) 
    {
        return DB::table('description_visits')
                 ->leftJoin('destinations', 'description_visits.id_destination', '=', 'destinations.id')
                 ->leftJoin('type_visits', 'description_visits.id_type_visit', '=', 'type_visits.id')
                 ->leftJoin('motive_visits', 'description_visits.id_motive', '=', 'motive_visits.id')
                 ->leftJoin('guests', 'description_visits.id_guest_description', '=', 'guests.id')
                 ->select('destinations.destination', 'type_visits.type_visit','motive_visits.id','guests.id','guests.cedula','guests.names','guests.lastNames','guests.photo_src','guests.id_type_guest','description_visits.*')
                 ->where('guests.id_type_guest', '=', $type_user)
                 ->whereBetween('description_visits.created_at',[$date_start,$date_end])
                 ->where(function ($query) use ($value) {
                    $query->where('guests.names', 'LIKE', '%'.$value.'%')
                    ->orWhere('guests.lastNames', 'LIKE', '%'.$value.'%')
                    ->orWhere('description_visits.motiveOther', 'LIKE', '%'.$value.'%')
                    ->orWhere('destinations.destination', 'LIKE', '%'.$value.'%')
                    //->orWhere('type_visits.type_visit', 'like', '%'.$value.'%')
                    ->orWhere('motive_visits.motive_visit', 'LIKE', '%'.$value.'%');
                 })
                ->orderBy('description_visits.id_description_visits', 'desc');
    }

    public static function editVisit($id) 
    {
        return DB::table('description_visits')
                 ->leftJoin('destinations', 'description_visits.id_destination', '=', 'destinations.id')
                 ->leftJoin('type_visits', 'description_visits.id_type_visit', '=', 'type_visits.id')
                 ->leftJoin('motive_visits', 'description_visits.id_motive', '=', 'motive_visits.id')
                 ->select('description_visits.*', 'destinations.destination', 'type_visits.type_visit','motive_visits.motive_visit')
                 ->where('description_visits.id_description_visits', '=', $id)
                 ->get();
    }
}
