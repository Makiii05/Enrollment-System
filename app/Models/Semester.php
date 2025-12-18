<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = [
        "code",
        "description",
        "academic_year",
        "start_date",
        "end_date",
        "status",
    ];

    public function prospectuses(){
        return $this->hasMany(Prospectus::class);
    }
}
