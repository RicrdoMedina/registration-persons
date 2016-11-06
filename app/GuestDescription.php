<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestDescription extends Model
{
    protected $table = 'description_visits';

    protected $fillable = ['id_guest_description','id_destination', 'id_motive','id_type_guest','id_type_visit','motive_other'];
}
