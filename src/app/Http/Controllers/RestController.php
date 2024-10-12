<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Rest;

class RestController extends Controller
{
    // 休憩時：休憩時刻のカラムのみを追加する
    public function restBegin()
    {   
        $attendance_id = Attendance::find(Auth::id())->whereDate('date', Carbon::today()->toDateString())->first();
        $off_start = [
            'attendance_id' => $attendance_id->id,  
            'rest_begin_time' => Carbon::now()
        ];
        Rest::create($off_start);
        
        return redirect('/');
    }

    // 休憩終了時：終了時刻のカラムのみを追加する
    public function restEnd()
    {
        $off_end = [
            'rest_end_time' => Carbon::now()
        ];
        Rest::find(Auth::id())->where('rest_end_time', null)->update($off_end);

        return redirect('/');
    }
}
