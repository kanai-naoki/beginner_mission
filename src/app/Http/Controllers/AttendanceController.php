<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;

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
        $timestamp  = [
            'user_id' => Auth::id(),
            'date' => Carbon::today()->toDateString(),
            'work_begin_time' => Carbon::now()
        ];       
        Attendance::create($timestamp); 
        return redirect('/');
    }

    // 編集して、退勤時刻のカラムのみを追加する
    public function workEnd()
    {        
        $out = [
            'work_end_time' => Carbon::now()
        ];
        Attendance::find(Auth::id())->whereDate('date', Carbon::today())->update($out);

        return redirect('/');
    }

    public function userAttendance()
    {
        // attendance,restモデルから情報を持ってくる処理※itemsに配列を作って、複数のデータベースのデータを引っ張てくる
        $attendances = Attendance::Paginate(5);
        return view('attendance', compact( 'attendances'));
    }

    //ユーザー一覧ページ
    public function userAll (Request $request)
    {
        $sorts = User::Paginate(5);
        return view('user_list', compact('sorts'));
    }

    // ユーザー勤怠詳細ページ
    public function userDetail (Request $request)
    {
        // user_idで情報を絞り込んで、休憩時間の合計、勤務時間を計算して表示する
        $user_works = Attendance::find($request->user_id);
        return view('user_attendance_detail' ,compact('user_works' ,''));
    }
    
}
