<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <style>
        label {
            display: inline-block;
            width: 80px;
        }
        table, td, th {
            border: 1px solid #888;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
@yield('content')
</body>
</html>
