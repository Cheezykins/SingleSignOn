<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\LinkCategory
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Link[] $links
 * @method static \Illuminate\Database\Query\Builder|\App\LinkCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LinkCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LinkCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LinkCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LinkCategory extends Model
{
    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
