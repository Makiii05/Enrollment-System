<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        "description",
        "amount",
        "type",
        "month_to_pay",
        "group",
        "academic_year",
        "program_id",
    ];

    public function program(){
        return $this->belongsTo(Program::class);
    }
}
