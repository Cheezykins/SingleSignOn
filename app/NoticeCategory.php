<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoticeCategory extends Model
{
    public function notices()
    {
        return $this->hasMany(Notice::class);
    }
}
