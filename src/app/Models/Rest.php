<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'rest_begin_time',
        'rest_end_time'
    ];

    protected $casts = [
        'rest_begin_time' => 'datetime',
        'rest_end_time' => 'datetime'
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
