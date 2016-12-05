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

    public function usedSpace()
    {
        return $this->capacity - $this->free_space;
    }

    public function percentageUsed()
    {
        return round(100 - (($this->free_space / $this->capacity) * 100), 2);
    }

    protected static function renderBytes($bytes, $precision = 2)
    {
        $factors = ['B', 'KiB', 'MiB', 'GiB', 'TiB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$precision}f %s", $bytes / pow(1024, $factor), $factors[(int)$factor]);
    }

    public function freeSpaceFormatted($precision = 2) {
        return self::renderBytes($this->free_space, $precision);
    }

    public function usedSpaceFormatted($precision = 2)
    {
        return self::renderBytes($this->usedSpace(), $precision);
    }

    public function capacityFormatted($precision = 2)
    {
        return self::renderBytes($this->capacity, $precision);
    }
}
