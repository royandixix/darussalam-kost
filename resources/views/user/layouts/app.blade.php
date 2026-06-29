<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Darussalam Kost')</title>

    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Volkhov:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

@if(!View::hasSection('hide_navbar'))
    @include('user.partials.navbar')
@endif

{{-- PAGE HEADER --}}
@if(View::hasSection('page_header'))
    <div class="bg-white border-bottom py-3">
        <div class="container">

            <h4 class="mb-0 fw-bold">
                @yield('page_header')
            </h4>

            @if(View::hasSection('page_subtitle'))
                <small class="text-muted">
                    @yield('page_subtitle')
                </small>
            @endif

        </div>
    </div>
@endif

<div class="container py-5">
    @yield('content')
</div>

@if(!View::hasSection('hide_navbar'))
    @include('user.partials.footer')
@endif

@include('user.partials.scripts')

</body>
</html>