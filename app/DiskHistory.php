<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DiskHistory
 *
 * @property int $id
 * @property int $disk_id
 * @property string $entry_date
 * @property int $capacity
 * @property int $free_space
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Disk $disk
 * @method static \Illuminate\Database\Query\Builder|\App\DiskHistory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DiskHistory whereDiskId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DiskHistory whereEntryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DiskHistory whereCapacity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DiskHistory whereFreeSpace($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DiskHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DiskHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DiskHistory extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function disk()
    {
        return $this->belongsTo(Disk::class);
    }

    public function usedSpace()
    {
        return $this->capacity - $this->free_space;
    }

    public function percentageUsed()
    {
        return round(100 - (($this->free_space / $this->capacity) * 100), 2);
    }

    public function freeSpaceFormatted($precision = 2) {
        return Disk::renderBytes($this->free_space, $precision);
    }

    public function usedSpaceFormatted($precision = 2)
    {
        return Disk::renderBytes($this->usedSpace(), $precision);
    }

    public function capacityFormatted($precision = 2)
    {
        return Disk::renderBytes($this->capacity, $precision);
    }
}
