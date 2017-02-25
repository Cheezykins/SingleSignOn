<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ServiceResponseHistory
 *
 * @property int $id
 * @property int $service_update_id
 * @property string $entry_date
 * @property int $response_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\ServiceUpdate $service_update
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceResponseHistory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceResponseHistory whereServiceUpdateId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceResponseHistory whereEntryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceResponseHistory whereResponseTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceResponseHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceResponseHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceResponseHistory extends Model
{
    public function service_update()
    {
        return $this->belongsTo(ServiceUpdate::class);
    }
}
