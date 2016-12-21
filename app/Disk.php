<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Disk
 *
 * @property integer $id
 * @property string $path
 * @property integer $capacity
 * @property integer $free_space
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DiskHistory[] $history
 * @method static \Illuminate\Database\Query\Builder|\App\Disk whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Disk wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Disk whereCapacity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Disk whereFreeSpace($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Disk whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Disk whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Disk extends Model
{

    /**
     * Creates a history object for the disk at its current setting.
     */
    public function addToHistory()
    {
        $history = new DiskHistory();
        $history->entry_date = $this->updated_at;
        $history->capacity = $this->capacity;
        $history->free_space = $this->free_space;
        $history->disk()->associate($this);
        $history->save();
    }

    public function history()
    {
        return $this->hasMany(DiskHistory::class);
    }

    public function usedSpace()
    {
        return $this->capacity - $this->free_space;
    }

    public function percentageUsed()
    {
        return round(100 - (($this->free_space / $this->capacity) * 100), 2);
    }

    public function freeSpaceFormatted($precision = 2)
    {
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

    public static function renderBytes($bytes, $precision = 2)
    {
        $factors = ['B', 'KiB', 'MiB', 'GiB', 'TiB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$precision}f %s", $bytes / pow(1024, $factor), $factors[(int)$factor]);
    }
}
