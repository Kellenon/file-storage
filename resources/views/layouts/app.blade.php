<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Файловое хранилище</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
@yield('styles')
@yield('content')
@yield('scripts')
</body>
</html>
