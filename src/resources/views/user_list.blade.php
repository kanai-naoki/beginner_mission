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
       <th class="user-list_header">UserID</th>
       <th class="user_list_header">氏名</th>
       <th class="user_list_header">詳細</th>
      </tr>
      {{-- @foreach ($user_lists as $user_list) --}}
      <tr class="user_list_row">
       <td class="user_list_item">家内</td>
       <td class="user_list_item">直紀</td>
       <td class="user_list_item">
        {{-- <form class="form" action="/user/detail" method="get">
        　@csrf 
         <button type="submit">詳細</button>
        </form> --}}     
       </td>  
      </tr>
      {{-- @endforeach --}}
    </table>
  </div>
</div>
@endsection