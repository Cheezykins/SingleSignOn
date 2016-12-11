<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Notice
 *
 * @property integer $id
 * @property integer $notice_category_id
 * @property string $title
 * @property string $body
 * @property boolean $active
 * @property string $show_from
 * @property string $show_to
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\NoticeCategory $category
 * @method static \Illuminate\Database\Query\Builder|\App\Notice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notice whereNoticeCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notice whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notice whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notice whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notice whereShowFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notice whereShowTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notice extends Model
{
    public function category()
    {
        return $this->belongsTo(NoticeCategory::class);
    }
}
