<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

use App\Models\Rest;
use App\Models\Attendance;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // 毎日午前0時になったら、勤務終了していないレコードを全て埋めて、翌日の打刻をさせる。
        $schedule->call(function () {
            
            // 休憩終了処理
            $rest_out = [
                'rest_end_time' => Carbon::now()
            ];
            Rest::where('rest_end_time', null)->update($rest_out);

            // 勤務終了処理
            $work_out = [
                'work_end_time' => Carbon::now()
            ];
            Attendance::whereDate('date', Carbon::yesterday())->where('work_end_time', null)->update($work_out);

            // 勤務開始処理
            $work_start  = [
                'user_id' => Auth::id(),
                'date' => Carbon::today()->toDateString(),
                'work_begin_time' => Carbon::now()
            ];       
            Attendance::create($work_start);

        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
