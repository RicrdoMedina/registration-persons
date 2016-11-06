<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    protected $table = 'enterprises';

    public $primaryKey='id_enterprise';

    public function guests()
    {
        //return $this->belongsToMany('miproyecto\Guest','enterprise_guest','enterprise_id','guest_id')->withPivot('enterprise_other');

        return $this->belongsToMany('miproyecto\Guest');
    }

}
