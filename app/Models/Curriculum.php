<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $fillable = [
        "curriculum",
        "status",
        "course_id",
    ];

    public function prospectuses(){
        return $this->hasMany(Prospectus::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
