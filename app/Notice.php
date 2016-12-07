<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    public function category()
    {
        return $this->belongsTo(NoticeCategory::class);
    }
}
