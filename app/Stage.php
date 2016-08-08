<?php

namespace Classistant;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    public function lesson() {
        return $this->belongsTo('App/Lesson');
    }
}
