<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
