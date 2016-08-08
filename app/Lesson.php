<?php

namespace Classistant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Lesson extends Model
{
    protected $dates = ['date'];

    public function cl() {
        return $this->belongsTo(cl::class, 'class_id', 'id');
    }

    public function stages() {
        return $this->hasMany(Stage::class);
    }

    public function scopeOwned($query) {
        $userId = Auth::user()->id;
        return $query->whereHas('cl', function($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }
}
