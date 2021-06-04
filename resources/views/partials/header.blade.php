<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MyGarden') }}</title>

    <!-- Styles -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

    <!-- Material icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- FavIcon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/png">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/png">

    <!-- Self included style and scripts -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
    <script src="{{ asset('js/ajax.js') }}" defer></script>

    @yield('pagespecificfile')
</head>
