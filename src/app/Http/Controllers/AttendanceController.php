<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rest;
use App\Models\Attendance;

class AttendanceController extends Controller
{
   public function index()
    {
        $user = Auth::user();
        return view('index', compact('user'));
    }

    // 日をまたいだ時点で、勤務終了処理、翌日の勤務開始処理を行うように条件分岐させる
    // if {Carbon::tomorrow('Asia/Tokyo');

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
        Attendance::find(Auth::id())->whereDate('date', Carbon::today())->where('work_end_time', null)->update($out);

        return redirect('/');
    }

    public function userAttendance()
    {
        $pdo = DB::connection()->getPdo();
        $sql = 'WITH work_times AS( SELECT id , TIMEDIFF(work_end_time, work_begin_time) as work_time FROM `attendances`) SELECT name, user_id, attendance_id, date, work_begin_time, work_end_time, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time)))) as rest_total_time, TIMEDIFF(work_time, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time))))) as work_really_time FROM `rests` INNER JOIN `attendances` ON attendances.id = rests.attendance_id INNER JOIN `users` ON users.id = attendances.user_id INNER JOIN `work_times` ON work_times.id = attendances.id GROUP BY attendance_id';
        $attendance_lists = $pdo->query($sql)->fetchall();
        dd($attendance_lists);
        
        // モデルを結合して、紐づいているテーブルのデータをすべて取得
        // $user_attendance_details = Attendance::select('user_id', 'name','attendance_id', 'date', 'work_begin_time', 'work_end_time', 'rest_begin_time', 'rest_end_time')
            // ->join('users', 'users.id', '=', 'user_id')
            // ->join('rests', 'rests.attendance_id', '=', 'attendances.id')
            // ->get();
        
        // $items = $user_attendance_details->groupBy('attendance_id');
        // dd($items);

        // $rest_total_times = $items->map(function($item) {
        //   $item(0)->rest_end_time - $item(0)->rest_begin_time;
        // });
        // dd($rest_total_times);
        // 差分を取得して、休憩時間を計算する（秒数で値を取得できる）
       
        // dd($time_details);

        // 総休憩時間を計算する※timeDiffで取ってきた時・分・秒のままsumで合計できない場合は、秒に一度直してから計算する
        // $rest_total_time = SEC_TO_TIME(SUM(TIME_TO_SEC($rest_time_Seconds)))
        
        // 差分を取得して、勤怠の総合計時間を計算する（※秒単位）‥⓶;
        // $date_attendance = $user_attendance_details->timediff('work_end_time', 'work_begin_time');

        // ⓶と⓵を差分して、勤務時間を計算する（※秒単位）‥⓷
        // $date_attendance_time = timeDiff($date_attendance, $rest_total_time);

        // 編集し直した値を配列にする→ページネーション
        // $attendances = Attendance::Paginate(5);
        return view('attendance', compact( 'attendance_lists'));
    }

    //ユーザー一覧ページ
    public function userAll ()
    {
        $sorts = User::Paginate(5);
        return view('user_list', compact('sorts'));
    }

    // ユーザー勤怠詳細ページ
    public function userDetail ()
    {
        // user_idで情報を絞り込んで、休憩時間の合計、勤務時間を計算して表示する
        $user_works = Attendance::find($request->user_id);
        return view('user_attendance_detail' ,compact('user_works' ,''));
    }
    
}
