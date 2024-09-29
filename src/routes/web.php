<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 認証ができている場合にのみ、打刻画面に入れる
Route::middleware('auth')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::get('/attendance/add',[AttendanceController::class, 'workBegin']);
    Route::get('/attendance/edit',[AttendanceController::class, 'workEnd']);
    Route::get('/rest/add',[RestController::class, 'restBegin']);
    Route::get('/rest/edit',[RestController::class, 'restEnd']);
    Route::get('/user/attendance',[AttendanceController::class, 'userAttendance']);
    Route::get('/user/attendance_date',[AttendanceController::class,'userAttendance_date']);
    Route::get('/user/list', [AttendanceController::class, 'userAll']);
    Route::get('/user/detail', [AttendanceController::class, 'userDetail']);
});

/*
// メール確認の通知
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// 送信された電子メールを確認リンクをクリックしたときに生成されるリクエスト
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

// メール確認の再送信（確認メールの紛失・削除対策）
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
*/

