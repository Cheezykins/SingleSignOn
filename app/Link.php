<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Link
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $url
 * @property string $icon_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read \App\LinkCategory $category
 * @method static \Illuminate\Database\Query\Builder|\App\Link whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Link whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Link whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Link whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Link whereIconName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Link whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Link whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Link extends Model
{

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'link_roles')->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(LinkCategory::class, 'category_id');
    }
}
