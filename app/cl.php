<?php

namespace Classistant;

use Illuminate\Database\Eloquent\Model;
use Classistant\User;

class cl extends Model
{
    protected $table = "classes";


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function lessons() {
        return $this->hasMany(Lesson::class, 'class_id', 'id');
    }
}
