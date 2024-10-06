@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('nav')
<nav class="header-nav">
  <ul class="header-nav-list">
    <li class="header-nav-item"><a href="/">ホーム</a></li>
    <li class="header-nav-item"> 
      <a href="/user/list">ユーザー一覧</a>
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
<div class="attendance_content">
  <div class="date_search">
    <a class="dete_search_subday" href="/date/search/subday">≪</a>
    <h2 class="date_search_day"></h2>
    <a class="date_search_addday" href="/date/search/addday">≫</a>
  </div>
  <div class="search_result_table">
    <table class="search_table_inner">
      <tr class="search_table_row">
        <th class="search_table_header">名前</th>
        <th class="search_table_header">勤務開始</th>
        <th class="search_table_header">勤務終了</th>
        <th class="search_table_header">休憩時間</th>
        <th class="search_table_header">勤務時間</th>
      </tr>
      @foreach ($attendance_lists as $attendance_list)
      <tr class="search_table_row">
        <td class="search_table_item">{{ $attendance_list->name }}</td>
        <td class="search_table_item">{{ $attendance_list->work_begin_time }}</td>
        <td class="search_table_item">{{ $attendance_list->work_end_time }}</td>  
        <td class="search_table_item">{{ $attendance_list->rest_total_time }}</td>
        <td class="search_table_item">{{ $attendance_list->work_really_time }}</td>
      </tr>
      @endforeach
    </table>
  </div> 
  <div class="pagenation_area"> 
    {{ $attendance_lists->links() }}
  </div>         
</div>
@endsection