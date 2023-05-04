<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ mix("/css/bootstrap.min.css") }}">
</head>
<body>

<div class="container">
    @include('navbar')
</div>
<div class="container page">
@yield('content')
</div>

<script src="{{ mix("/js/app.js") }}"></script>
@yield('scripts')

</body>
</html>
