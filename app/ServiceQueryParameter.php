<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ServiceQueryParameter
 *
 * @property int $id
 * @property int $service_id
 * @property string $key
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Service $service
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceQueryParameter whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceQueryParameter whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceQueryParameter whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceQueryParameter whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceQueryParameter whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceQueryParameter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
