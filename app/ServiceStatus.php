<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ServiceStatus
 *
 * @property integer $id
 * @property string $status
 * @property string $group
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServiceUpdate[] $service_updates
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceStatus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceStatus whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceStatus whereGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceStatus extends Model
{
    protected $fillable = ['status', 'group'];

    const STATUS_UNKNOWN = 'Unknown';
    const STATUS_UP = 'Up';
    const STATUS_DOWN = 'Down';
    const STATUS_RECOVERING = 'Pending: Up';
    const STATUS_FAILING = 'Pending: Down';
    const STATUS_SLOW = 'Up: Slow';
    const STATUS_VSLOW = 'Up: Very Slow';

    const GROUP_NEUTRAL = 'Neutral';
    const GROUP_GOOD = 'Good';
    const GROUP_BAD = 'Bad';
    const GROUP_WARNING = 'Warning';

    public function service_updates()
    {
        return $this->hasMany(ServiceUpdate::class);
    }
}
