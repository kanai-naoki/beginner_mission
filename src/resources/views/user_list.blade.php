@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_list.css') }}">
@endsection

@section('nav')
<nav class="header-nav">
  <ul class="header-nav-list">
    <li class="header-nav-item">
      <a href="/">ホーム</a>
    </li>
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
<div class="user_list_content">
  <div class="user_list_header">
    <h2>ユーザー一覧</h2>
  </div>
  <div class="user_list_table">
    <table class="user_list_table_inner">
      <tr class="user_list_table_row">
       <th class="user_list_table_header">ID</th>
       <th class="user_list_table_header">氏名</th>
       <th class="user_list_table_header">勤怠一覧</th>
      </tr>
      @foreach ($sorts as $user_list)
      <tr class="user_list_table_row">
       <td class="user_list_table_item">{{ $user_list->id }}</td>
       <td class="user_list_table_item">{{ $user_list->name }}</td>
       <td class="user_list_table_item">
          <form class="user_detail_get_form" action="/user/detail" method="GET">
            <input type="hidden" name="user_id" value="{{ $user_list->id }}">
            <button class="user_detail_button">詳細</button>
          </form>             
       </td>  
      </tr>
      @endforeach
    </table>
  </div>
  <div class="pagenation_area">
    {{ $sorts->links() }}
  </div>
</div>
@endsection