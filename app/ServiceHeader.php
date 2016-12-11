<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ServiceHeader
 *
 * @property integer $id
 * @property integer $service_id
 * @property string $key
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Service $service
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceHeader whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceHeader whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceHeader whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceHeader whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceHeader whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceHeader whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceHeader extends Model
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
