<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceResponseHistory extends Model
{
    public function service_update()
    {
        return $this->belongsTo(ServiceUpdate::class);
    }
}
