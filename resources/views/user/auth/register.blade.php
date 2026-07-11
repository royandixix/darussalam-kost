<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Darussalam Kost</title>

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
            background-image: linear-gradient(rgba(0, 36, 36, 0.78), rgba(0, 36, 36, 0.78)), url("{{ asset('property-1.0.0/images/hero_bg_2.jpg') }}");
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

        textarea.form-control {
            height: auto;
        }

        .profile-preview-box {
            width: 110px;
            height: 110px;
            border: 1px solid #dfe5e5;
            background: #f8f9fa;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            margin-bottom: 12px;
        }

        .profile-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
                                Daftar akun penghuni untuk melakukan booking kamar, pembayaran, laporan perbaikan, dan feedback secara online.
                            </p>

                            <div class="mb-4">
                                <a href="{{ route('login') }}" class="btn btn-outline-light py-3 px-4 mb-2">
                                    Masuk ke Akun
                                </a>

                                <a href="{{ route('register') }}" class="btn btn-light py-3 px-4 mb-2">
                                    Daftar Akun
                                </a>
                            </div>

                            <p class="mb-0">
                                Satu akun untuk semua kebutuhan penghuni kost.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7">
                        <div class="auth-card h-100">

                            <span class="flaticon-building"></span>

                            <h2 class="font-weight-bold text-primary heading mb-3">
                                Buat Akun Baru
                            </h2>

                            <p class="text-dark mb-4">
                                Lengkapi data berikut untuk mendaftar sebagai penghuni.
                            </p>

                            <form id="registerForm" action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <div class="col-12 col-md-6 mb-4">
                                        <label class="form-label fw-semibold">
                                            Nama Lengkap
                                        </label>

                                        <input 
                                            type="text" 
                                            name="name" 
                                            id="name"
                                            value="{{ old('name') }}"
                                            class="form-control rounded-0"
                                            placeholder="Masukkan nama lengkap"
                                            required
                                        >
                                    </div>

                                    <div class="col-12 col-md-6 mb-4">
                                        <label class="form-label fw-semibold">
                                            Nomor Telepon
                                        </label>

                                        <input 
                                            type="text" 
                                            name="phone" 
                                            id="phone"
                                            value="{{ old('phone') }}"
                                            class="form-control rounded-0"
                                            placeholder="Contoh: 081234567890"
                                            required
                                        >
                                    </div>

                                    <div class="col-12 mb-4">
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

                                    <div class="col-12 mb-4">
                                        <label class="form-label fw-semibold">
                                            Alamat Domisili
                                        </label>

                                        <textarea 
                                            name="address" 
                                            id="address"
                                            rows="3"
                                            class="form-control rounded-0"
                                            placeholder="Masukkan alamat domisili"
                                            required
                                        >{{ old('address') }}</textarea>
                                    </div>

                                    <div class="col-12 mb-4">
                                        <label class="form-label fw-semibold">
                                            Foto Profil
                                        </label>

                                        <div class="profile-preview-box" id="photoPreviewBox">
                                            <span id="photoPreviewText">
                                                Preview
                                            </span>

                                            <img src="" alt="Preview Foto Profil" id="photoPreviewImage" class="d-none">
                                        </div>

                                        <input 
                                            type="file" 
                                            name="photo" 
                                            id="photo"
                                            class="form-control rounded-0"
                                            accept="image/*"
                                        >

                                        <small class="text-black-50">
                                            Opsional. Format JPG, JPEG, PNG, atau WEBP. Maksimal 2MB.
                                        </small>
                                    </div>

                                    <div class="col-12 col-md-6 mb-4">
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

                                            <button type="button" class="btn btn-outline-primary rounded-0" onclick="togglePassword('passwordField')">
                                                Lihat
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-4">
                                        <label class="form-label fw-semibold">
                                            Konfirmasi Sandi
                                        </label>

                                        <div class="input-group">
                                            <input 
                                                type="password" 
                                                name="password_confirmation" 
                                                id="passwordConfirmationField"
                                                class="form-control rounded-0"
                                                placeholder="Ulangi kata sandi"
                                                required
                                            >

                                            <button type="button" class="btn btn-outline-primary rounded-0" onclick="togglePassword('passwordConfirmationField')">
                                                Lihat
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <button type="submit" id="submitBtn" class="btn btn-primary text-white py-3 px-4 w-100">
                                    Daftar Akun Baru
                                </button>

                                <div class="text-center mt-4">
                                    <span class="text-black-50">
                                        Sudah punya akun?
                                    </span>

                                    <a href="{{ route('login') }}" class="text-primary fw-semibold">
                                        Masuk sekarang
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
            title: 'Registrasi Gagal',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonText: 'Periksa Lagi'
        });
    </script>
@endif

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);

        if (field.type === 'password') {
            field.type = 'text';
        } else {
            field.type = 'password';
        }
    }

    const photoInput = document.getElementById('photo');
    const photoPreviewText = document.getElementById('photoPreviewText');
    const photoPreviewImage = document.getElementById('photoPreviewImage');

    photoInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            photoPreviewImage.src = '';
            photoPreviewImage.classList.add('d-none');
            photoPreviewText.classList.remove('d-none');
            return;
        }

        photoPreviewImage.src = URL.createObjectURL(file);
        photoPreviewImage.classList.remove('d-none');
        photoPreviewText.classList.add('d-none');
    });

    document.getElementById('registerForm').addEventListener('submit', function () {
        const button = document.getElementById('submitBtn');

        button.innerText = 'Mendaftar...';
        button.disabled = true;
    });
</script>

</body>
</html>