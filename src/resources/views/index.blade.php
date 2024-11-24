@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<script src="{{ asset('/js/search.js') }}"></script>
@endsection

@section('nav')
<nav class="header-nav">
  <ul class="header-nav-list">
    <li class="header-nav-item">
      <a href="/">ホーム</a>
    </li>
    <li class="header-nav-item">
      <form class="header_sort" action="/user/attendance" method="get">
        <input type="hidden" name="days" value="{{ $days }}">
        <button class="days_list">日付一覧</button>
      </form>
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
<div class="timestamp_content">
  <div class="timestamp_header">
    <h2>{{ $user->name }}さんお疲れ様です！</h2>
  </div>
  <div class="timestamp_form_area">
    <div class="timestamp_work_begin_area">  
      <a class="form" href="/attendance/add">勤務開始</a>
    </div>
    <div class="timestamp_work_end_area">
      <a class="form" href="/attendance/edit">勤務終了</a>
    </div>
    <div class="timestamp_rest_begin_area">
      <a class="form" href="/rest/add">休憩開始</a>
    </div>
    <div class="timestamp_rest_end_area">
      <a class="form" href="/rest/edit">休憩終了</a>
    </div>
  </div>
</div>
@endsection