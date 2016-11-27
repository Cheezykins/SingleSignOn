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
    //
}
