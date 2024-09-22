<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
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

    public function userAttendance($request)
    {
        // クエリビルダによって、加工したデータを取得
        // $date = $request->input;

        $attendance_lists = DB::table('attendances')
            ->select('name', 'user_id', 'attendance_id', 'date', 'work_begin_time', 'work_end_time', DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time)))) as rest_total_time, TIMEDIFF(TIMEDIFF(work_end_time, work_begin_time), SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time))))) as work_really_time'))
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->join('rests', 'attendances.id', '=', 'rests.attendance_id')
            // 入力された日付を条件として絞り込みをかける処理
            // ->where('date', $date)
            ->groupby('attendance_id')
            ->get();

        // ↓ページネーション生成まで移動

        // ※参考：pdo操作によって加工データを取得する方法

        // $pdo = DB::connection()->getPdo();

        // $sql = 'WITH work_times AS( SELECT id , TIMEDIFF(work_end_time, work_begin_time) as work_time FROM `attendances`) SELECT name, user_id, attendance_id, date, work_begin_time, work_end_time, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time)))) as rest_total_time, TIMEDIFF(work_time, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time))))) as work_really_time FROM `rests` INNER JOIN `attendances` ON attendances.id = rests.attendance_id INNER JOIN `users` ON users.id = attendances.user_id INNER JOIN `work_times` ON work_times.id = attendances.id GROUP BY attendance_id';

        // クエリで加工したデータを配列で引っ張ってくる処理
        // $attendance_lists = $pdo->query($sql)->fetchall();

        // 加工したデータを表示できるように、配列に変換
        // $attendance_lists_pagination = collect($attendance_lists);


        // ページネーションを生成
        $perPage = 5;
        $page = Paginator::resolveCurrentPage('page');
        $pageData = $attendance_lists->slice(($page - 1) * $perPage, $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];

        $paginatorDatas = new LengthAwarePaginator($pageData, $attendance_lists->count(), $perPage, $page, $options);
        
        return view('attendance', compact( 'paginatorDatas'));
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
        $pdo = DB::connection()->getPdo();

        $sql = 'WITH work_times AS( SELECT id , TIMEDIFF(work_end_time, work_begin_time) as work_time FROM `attendances`) SELECT name, user_id, attendance_id, date, work_begin_time, work_end_time, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time)))) as rest_total_time, TIMEDIFF(work_time, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end_time, rest_begin_time))))) as work_really_time FROM `rests` INNER JOIN `attendances` ON attendances.id = rests.attendance_id INNER JOIN `users` ON users.id = attendances.user_id INNER JOIN `work_times` ON work_times.id = attendances.id GROUP BY attendance_id';

        $user_details = $pdo->query($sql)->fetchall();

        $user_details_pagination = collect($user_details);
        dd($user_details_pagination);
        // user_idで情報を絞り込んで、休憩時間の合計、勤務時間を計算して表示する
        
        return view('user_attendance_detail' ,compact('',));
    }
    
}
