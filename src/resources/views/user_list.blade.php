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
      <a href="/attendance">日付一覧</a>
    </li>
    <li class="header-nav-item">
      <form class="form" action="{{ route('logout') }}" method="post">
      @csrf
      <button type="submit">ログアウト</button>
    </li>    
  </ul>
</nav>
@endsection

@section('content')
<div class="user_list_content">
  <div class="user_list_header">
    <h2>ユーザー一覧</h2>
  </div>
  <div class="user_list_area">
    <table class="user_list_inner">
      <tr class="user_list_row">
       <th class="todo-table__header">UserID</th>
       <th class="todo-table__header">氏名</th>
       <th class="todo-table__header">詳細</th>
      </tr>
      @foreach ($user_lists as $user_list)
      <tr class="user_list_row">
       <td class="user_list_item">{{ $user_list->id }}</td>
       <td class="user_list_item">{{ $user_list->name }}</td>
       <td class="user_list_item"></td>  
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endsection