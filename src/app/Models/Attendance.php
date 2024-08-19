<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 
        'work_begin_time', 
        'work_end_time'
    ];

    public function relation()
    {
        return $this->belongsTo(User::class);
    }
}
