<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'proctor',
        'date',
        'start_time',
        'end_time',
        'status',
        'process',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];


    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}
