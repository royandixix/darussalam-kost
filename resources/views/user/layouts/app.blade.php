<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Darussalam Kost')</title>

    <link rel="shortcut icon" href="{{ asset('property-1.0.0/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('property-1.0.0/fonts/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('property-1.0.0/fonts/flaticon/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('property-1.0.0/css/tiny-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('property-1.0.0/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('property-1.0.0/css/style.css') }}">
</head>
<body>

@include('user.partials.navbar')

@hasSection('hide_page_header')
@else
    @include('user.partials.header')
@endif

@yield('content')

@include('user.partials.footer')

<div id="overlayer"></div>
<div class="loader">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<script src="{{ asset('property-1.0.0/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('property-1.0.0/js/tiny-slider.js') }}"></script>
<script src="{{ asset('property-1.0.0/js/aos.js') }}"></script>
<script src="{{ asset('property-1.0.0/js/navbar.js') }}"></script>
<script src="{{ asset('property-1.0.0/js/counter.js') }}"></script>
<script src="{{ asset('property-1.0.0/js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            confirmButtonText: 'Oke'
        });
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonText: 'Periksa Lagi'
        });
    </script>
@endif

@stack('scripts')

</body>
</html>