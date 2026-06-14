<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Darussalam Kost')</title>

    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Volkhov:wght@700&display=swap" rel="stylesheet">
</head>
<body>

@hasSection('hide_navbar')
@else
    @include('user.partials.navbar')
@endif

<div class="container py-5">
    @yield('content')
</div>

@hasSection('hide_navbar')
@else
    @include('user.partials.footer')
@endif

@include('user.partials.scripts')

</body>
</html>