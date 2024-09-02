<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Rest;

class RestController extends Controller
{
    // 休憩時：休憩時刻のカラムのみを追加する
    public function restBegin()
    {   
        $attendance_id = Attendance::find(Auth::id())->whereDate('date', Carbon::today())->where('work_end_time', null)->first();
        $timestamp = [
            'attendance_id' => $attendance_id->id,  
            'rest_begin_time' => Carbon::now()
        ];
        Rest::create($timestamp);
        
        return redirect('/');
    }

    // 休憩終了時：終了時刻のカラムのみを追加する
    public function restEnd()
    {
        $timestamp = [
            'rest_end_time' => Carbon::now()
        ];
        Rest::find(Auth::id())->whereDate('rest_begin_time', Carbon::today())->where('rest_end_time', null)->update($timestamp);

        return redirect('/');
    }
}
