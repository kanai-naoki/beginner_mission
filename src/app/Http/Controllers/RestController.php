<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Rest;

class RestController extends Controller
{
    // 休憩時：休憩時刻のカラムのみを追加する
    public function restBegin(Request $request)
    {
        $timestamp = [
            'rest_begin_time' => new Carbon('now')
        ];
        Rest::create($timestamp);
        
        return redirect('/');
    }

    // 休憩終了時：終了時刻のカラムのみを追加する
    public function restEnd(Request $request)
    {
        $timestamp = [
            'rest_end_time' => new Carbon('now')
        ];
        Rest::find($request->attendance_id)->update($timestamp);

        return redirect('/');
    }
}
