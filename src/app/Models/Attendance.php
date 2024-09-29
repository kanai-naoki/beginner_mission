<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date', 
        'work_begin_time', 
        'work_end_time'
    ];

    public function rest()
    {
        return $this->hasMany(Rest::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
