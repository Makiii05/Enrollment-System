<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        "code",
        "description",
        "status",
    ];

    public function courses(){
        return $this->hasMany(Course::class);
    }
}
