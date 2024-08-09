@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
<div class="timestamp_content">
  <div class="timestamp_header">
    <h2>{{ $user->name }}さんお疲れ様です！</h2>
  </div>
  <div class="timestamp_form_area">
    <div class="timestamp_work_begin_area">  
      <form class="form" action="/attendance/add" method="post">
        @csrf
        <input class="timestamp_button" type="submit" name="attendance" value="勤務開始">
      </form>
    </div>
    <div class="timestamp_work_end_area">
      <form class="form" action="/attendance/edit" method="post">
        @csrf
        @method('PATCH')
        <input class="timestamp_button" type="submit" name="leaving" value="勤務終了">
      </form>
    </div>
    <div class="timestamp_rest_begin_area">
      <form class="form" action="/rest/add" method="post">
        @csrf
        <input class="timestamp_button" type="submit" name="rest_begin" value="休憩開始">
      </form>
    </div>
    <div class="timestamp_rest_end_area">
      <form class="form" action="/rest/edit" method="post">
        @csrf
        @method('PATCH')
        <input class="timestamp_button" type="submit" name="rest_end" value="休憩終了">
      </form>
    </div>
  </div>
</div>
@endsection