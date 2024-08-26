@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_attendance_detail.css') }}">
@endsection

@section('nav')
<nav class="header-nav">
  <ul class="header-nav-list">
    <li class="header-nav-item">
      <a href="/">ホーム</a>
    </li>
    <li class="header-nav-item">
      <a href="/attendance">日付一覧</a>
    </li>
    <li class="header-nav-item">
      <form class="form" action="{{ route('logout') }}" method="post">
      @csrf
      <button class="logout_button" type="submit">ログアウト</button>
    </li>    
  </ul>
</nav>
@endsection

@section('content')
<div class="user_attendance_detail_content">
  <div class="user_attendance_detail_header">
   <h2>氏名</h2>
  </div>
  <div class="user_attendance_detail-table">
    <table class="user_attendance_detail-table_inner">
      <tr class="user_attendance_detail-table_row">
        <th class="user_attendance_detail-table_header">日付</th>
        <th class="user_attendance_detail-table_header">勤務開始</th>
        <th class="user_attendance_detail-table_header">勤務終了</th>
        <th class="user_attendance_detail-table_header">休憩時間</th>
        <th class="user_attendance_detail-table_header">勤務時間</th>
      </tr>
      @foreach ($user_works as $user_work)
      <tr class="user_attendance_detail-table_row">
        <td class="user_attendance_detail-table">{{$user_work->date}}</td> 
        <td class="user_attendance_detail-table">{{$user_work->work_begin_time}}</td>  
        <td class="user_attendance_detail-table">{{$user_work->work_end_time}}</td>
        {{-- <td class="user_attendance_detail-table">{{$item->休憩時間の合計を表す変数。全部の休憩時間を足す処理}}</td> --}}
        {{-- <td class="user_attendance_detail-table">{{$item->勤務時間の合計を表す変数。休憩時間の合計を勤務時間からの合計から引く処理}}</td> --}}
      </tr>
      @endforeach
    </table>    
  </div> 
  <div class="pagenation_area">
    {{-- {{ $attendances->links() }} --}}
  </div>         
</div>
@endsection