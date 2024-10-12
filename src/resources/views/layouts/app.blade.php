<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Atte</title>
   <link rel="stylesheet" href="{{ asset('css/app.css') }}">
   <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
   @yield('css')    
</head>
<body>
 <header class="header">
   <h1 class="header_ttl">Atte</h1>
   @yield('nav')
 </header>
 <main class="main">
   @yield('content')
 </main>
 <footer class="footer">
   <p>Atte,inc</p>
 </footer>    
</body>
</html>