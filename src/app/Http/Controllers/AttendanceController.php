<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
   public function index()
    {
        return view('index');
    }

    // 出勤時：日付・出勤時刻のカラムのみを追加する
    public function workBegin(Request $request)
    {     
        $timestamp = [
            'user_id' => Auth::id(),
            'date' => new Carbon('today'),
            'work_begin_time' => new Carbon('now')
        ];
        Attendance::create($timestamp);
        
        return redirect('/');
    }

    // 編集して、退勤時刻のカラムのみを追加する
    public function workEnd(Request $request)
    {        
        $timestamp = [
            'work_end_time' => new Carbon('now')
        ];
        Attendance::find($request->user_id)->update($timestamp);

        return redirect('/');
    }

    public function attendance()
    {
        // attendance,restモデルから情報を持ってくる処理
        $Attendances = Attendance::Paginate(5);
        return view('attendance', compact('attendance'));
    }
}
