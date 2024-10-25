<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Rest;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $days = Carbon::today()->toDateString();
        return view('index', compact('user', 'days'));
    }

    // 出勤時：日付・出勤時刻のカラムのみを追加する
    public function workBegin()
    {  
        $start  = [
            'user_id' => Auth::id(),
            'date' => Carbon::today()->toDateString(),
            'work_begin_time' => Carbon::now()
        ];       
        Attendance::create($start); 
        return redirect('/');
    }

    // 編集して、退勤時刻のカラムのみを追加する
    public function workEnd()
    {        
        $out = [
            'work_end_time' => Carbon::now()
        ];
        Attendance::find(Auth::id())->whereDate('date', Carbon::today()->toDateString())->where('work_end_time', null)->update($out);

        return redirect('/');
    }

    public function userAttendance(Request $request)
    {
        // リクエストされた日付の情報を取得
        $date = [
            'day' => $request->days,
            'subday' => Carbon::parse($request->days)->subDay(1)->toDateString(),
            'addday' => Carbon::parse($request->days)->addDay(1)->toDateString()
        ];
        
        // 中身の値を取得できる形式に変換
        $date_format = collect($date);
        
        //日付ごとの絞り込みを行う 
        $attendance_lists = Attendance::select('name', 'user_id', 'attendance_id', 'date', 'work_begin_time', 'work_end_time', DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time)))) as rest_total_time, TIMEDIFF(TIMEDIFF(work_end_time, work_begin_time), SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time))))) as work_really_time'))
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->join('rests', 'attendances.id', '=', 'rests.attendance_id')
            ->whereDate('date', $request->days)
            ->groupby('attendance_id')
            ->Paginate(5);
       
        return view('attendance', compact('attendance_lists', 'date_format'));
        
    }

    //ユーザー一覧ページ
    public function userAll (Request $request)
    {
        $days = Carbon::today()->toDateString();
        $sorts = User::Paginate(5);
        return view('user_list', compact('sorts','days'));
    }

    // ユーザー勤怠詳細ページ
    public function userDetail (Request $request)
    { 
        $input = [
            'days' => Carbon::today()->toDateString(),
            'name' => $request->name 
        ];

        $user = collect($input);

        $attendance_details = Attendance::select('name', 'user_id', 'attendance_id', 'date', 'work_begin_time', 'work_end_time', DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time)))) as rest_total_time, TIMEDIFF(TIMEDIFF(work_end_time, work_begin_time), SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time))))) as work_really_time'))
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->join('rests', 'attendances.id', '=', 'rests.attendance_id')
            ->where('user_id', $request->user_id)
            ->groupby('attendance_id')
            ->Paginate(5);
        
        return view('user_attendance_detail', compact('attendance_details', 'user'));
    }   
    
    
}
