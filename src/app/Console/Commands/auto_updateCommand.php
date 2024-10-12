<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Rest;
use App\Models\Attendance;

class auto_updateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:auto_update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
    }
}
