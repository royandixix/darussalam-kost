<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Darussalam Kost</title>

    <link rel="shortcut icon" href="{{ asset('property-1.0.0/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('property-1.0.0/fonts/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('property-1.0.0/fonts/flaticon/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('property-1.0.0/css/tiny-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('property-1.0.0/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('property-1.0.0/css/style.css') }}">

    <style>
        body {
            min-height: 100vh;
            background-image: linear-gradient(rgba(0, 36, 36, 0.78), rgba(0, 36, 36, 0.78)), url("{{ asset('property-1.0.0/images/hero_bg_3.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
        }

        .auth-card {
            background: #ffffff;
            padding: 40px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.18);
        }

        .auth-info {
            background: rgba(0, 85, 85, 0.92);
            color: #ffffff;
            padding: 40px;
            height: 100%;
        }

        .auth-logo-box {
            width: 56px;
            height: 56px;
            background: #ffffff;
            color: #005555;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 24px;
        }

        .form-control {
            height: 52px;
        }

        @media (max-width: 991px) {
            .auth-wrapper {
                padding: 24px 0;
            }

            .auth-card {
                padding: 28px;
            }

            .auth-info {
                padding: 28px;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="row g-0">

                    <div class="col-12 col-lg-5">
                        <div class="auth-info">
                            <div class="auth-logo-box">
                                <span class="flaticon-house"></span>
                            </div>

                            <h2 class="mb-4">
                                Darussalam Kost
                            </h2>

                            <p class="mb-4">
                                Platform pemesanan kamar kost berbasis website untuk memudahkan penghuni melakukan booking, pembayaran, laporan perbaikan, dan feedback.
                            </p>

                            <div class="mb-4">
                                <a href="{{ route('login') }}" class="btn btn-light py-3 px-4 mb-2">
                                    Masuk ke Akun
                                </a>

                                <a href="{{ route('register') }}" class="btn btn-outline-light py-3 px-4 mb-2">
                                    Daftar Akun
                                </a>
                            </div>

                            <p class="mb-0">
                                Kelola kebutuhan kost kamu dalam satu platform.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7">
                        <div class="auth-card h-100">

                            <span class="flaticon-building"></span>

                            <h2 class="font-weight-bold text-primary heading mb-3">
                                Selamat Datang
                            </h2>

                            <p class="text-dark mb-4">
                                Silakan masuk menggunakan email dan kata sandi kamu.
                            </p>

                            <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Alamat Email
                                    </label>

                                    <input 
                                        type="email" 
                                        name="email" 
                                        id="email"
                                        value="{{ old('email') }}"
                                        class="form-control rounded-0"
                                        placeholder="Masukkan alamat email"
                                        required
                                    >
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Kata Sandi
                                    </label>

                                    <div class="input-group">
                                        <input 
                                            type="password" 
                                            name="password" 
                                            id="passwordField"
                                            class="form-control rounded-0"
                                            placeholder="Masukkan kata sandi"
                                            required
                                        >

                                        <button type="button" class="btn btn-outline-primary rounded-0" onclick="togglePassword()">
                                            Lihat
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="remember" class="me-2">
                                        <span class="text-dark">
                                            Ingat sesi perangkat ini
                                        </span>
                                    </label>
                                </div>

                                <button type="submit" id="submitBtn" class="btn btn-primary text-white py-3 px-4 w-100">
                                    Masuk ke Platform
                                </button>

                                <div class="text-center mt-4">
                                    <span class="text-black-50">
                                        Belum punya akun?
                                    </span>

                                    <a href="{{ route('register') }}" class="text-primary fw-semibold">
                                        Daftar sekarang
                                    </a>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

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
            title: 'Login Gagal',
            text: @json($errors->first()),
            confirmButtonText: 'Coba Lagi'
        });
    </script>
@endif

<script>
    function togglePassword() {
        const field = document.getElementById('passwordField');

        if (field.type === 'password') {
            field.type = 'text';
        } else {
            field.type = 'password';
        }
    }

    document.getElementById('loginForm').addEventListener('submit', function () {
        const button = document.getElementById('submitBtn');

        button.innerText = 'Memproses...';
        button.disabled = true;
    });
</script>

</body>
</html>