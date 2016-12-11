<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceQueryParameter extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
