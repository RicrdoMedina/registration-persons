<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnterpriseGuest extends Model
{
    protected $table = 'enterprise_guest';

    public $primaryKey='id_enterprise_guest';

    protected $fillable = ['guest_id','enterprise_id', 'enterpriseOther'];

    public function setEnterpriseOtherAttribute($value)
    {
        $this->attributes['enterpriseOther'] = ucfirst($value);
    }

}
