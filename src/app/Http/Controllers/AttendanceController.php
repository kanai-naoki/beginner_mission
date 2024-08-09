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
        Attendance::find($request->user_id->date)->update($timestamp);

        return redirect('/');
    }

    public function pagination()
    {
        // attendance,restモデルから情報を持ってくる処理
        $Attendances = Attendance::Paginate(5);
        return view('attendance', compact('attendance'));
    }

    //ユーザー一覧ページ
    public function userAll ()
    {
        $user_lists = User::all();
        return view('user_list', compact('user_lists'));
    }

    // ユーザー勤怠詳細ページ
    public function userDetail ()
    {
        // user_idで情報を絞り込んで、休憩時間の合計、勤務時間を計算して表示する
        return view('user_attedance_detail');
    }
    
}
