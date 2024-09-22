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
      <a href="/user/attendance">日付一覧</a>
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
      @foreach ($paginatorDatas as $paginatorData)
      <tr class="search_table_row">
        <td class="search_table_item">{{ $paginatorData->name }}</td>
        <td class="search_table_item">{{ $paginatorData->work_begin_time }}</td>
        <td class="search_table_item">{{ $paginatorData->work_end_time }}</td>  
        <td class="search_table_item">{{ $paginatorData->rest_total_time }}</td>
        <td class="search_table_item">{{ $paginatorData->work_really_time }}</td>
      </tr>
      @endforeach
    </table>
  </div> 
  <div class="pagenation_area">
    {{-- <ul class="pagination" role="navigation"> --}}
      {{-- <li class="page-item"> --}}
        {{-- <a class="page-link" href=""></a> --}}
        {{-- <a class="page-link" href=""></a> --}}
      {{-- </li> --}}
    {{-- </ul> --}}
    {{ $paginatorDatas->links() }}
  </div>         
</div>
@endsection