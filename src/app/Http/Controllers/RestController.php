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
    public function restBegin(Request $request)
    {
        $timestamp = [
            'attendance_id' => Attendance::find(Auth::id())->whereDate('date', Carbon::today()),
            'rest_begin_time' => Carbon::now()
        ];
        Rest::create($timestamp);
        
        return redirect('/');
    }

    // 休憩終了時：終了時刻のカラムのみを追加する
    public function restEnd(Request $request)
    {
        $timestamp = [
            'rest_end_time' => Carbon::now()
        ];
        Rest::find($request->attendance_id)->update($timestamp);

        return redirect('/');
    }
}
