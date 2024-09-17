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
      @foreach ($attendance_lists as $attendance_list)
      <tr class="user_attendance_detail-table_row">
        <td class="user_attendance_detail-table">{{ $attendance_list['date'] }}</td> 
        <td class="user_attendance_detail-table">{{ $attendance_list['work_begin_time'] }}</td>  
        <td class="user_attendance_detail-table">{{ $attendance_list['work_end_time'] }}</td>
        <td class="user_attendance_detail-table">{{ $attendance_list['rest_total_time'] }}</td>
        <td class="user_attendance_detail-table">{{ $attendance_list['work_really_time'] }}</td>
      </tr>
      @endforeach
    </table>    
  </div> 
  <div class="pagenation_area">
    {{-- {{ $attendances->links() }} --}}
  </div>         
</div>
@endsection