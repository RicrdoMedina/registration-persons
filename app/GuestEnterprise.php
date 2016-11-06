<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestEnterprise extends Model
{
    protected $table = 'guest_enterprises';

    protected $fillable = ['id_guest','id_enterprise'];
}
