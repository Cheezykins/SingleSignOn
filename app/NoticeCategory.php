<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\NoticeCategory
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Notice[] $notices
 * @method static \Illuminate\Database\Query\Builder|\App\NoticeCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NoticeCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NoticeCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NoticeCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NoticeCategory extends Model
{
    public function notices()
    {
        return $this->hasMany(Notice::class);
    }
}
