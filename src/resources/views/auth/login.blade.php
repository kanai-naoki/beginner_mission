@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login_content">
  <div class="login_header">
    <h2>ログイン</h2>
  </div>
  <div class="login_form_area">
    <form class="form" action="{{ route('login') }}" method="post">
      @csrf 
      <input class="form_email" type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}" >
      <input class="form_password" type="password" name="password" placeholder="パスワード">
      <input class="submit" type="submit" value="ログイン">
    </form>
  </div>
  <div class="login_registerlink">
    <p>アカウントをお持ちでない方はこちらから<br>
      <a href="/{{ route('register') }}">会員登録</a>
    </p>
  </div>
</div>
@endsection