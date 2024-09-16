@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('nav')
<nav class="header-nav">
  <ul class="header-nav-list">
    <li class="header-nav-item"><a href="/">ホーム</a></li>
    {{-- 日付一覧のリンク先が不明なので、保留 <li class="header-nav-item"> 
      <form class="form" action="/attendance/date_list" method="get">
        <button class="header-nav__button">日付一覧</button>
      </form>
    </li>--}}
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
  {{-- 日付による検索機能を導入、前日・翌日に遷移するアイコン作成 --}}
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
        <td class="search_table_item">{{$attendance_list->name}}</td>
        <td class="search_table_item">{{$attendance_list->work_begin_time}}</td>
        <td class="search_table_item">{{$attendance_list->work_end_time}}</td>  
        <td class="search_table">{{$attendance_list->rest_total_time}}</td>
        <td class="search_table">{{$attendance_list->work_really_time}}</td>
      </tr>
      @endforeach
    </table>
  </div> 
  <div class="pagenation_area">
    {{ $attendances->links() }}
  </div>         
</div>
@endsection