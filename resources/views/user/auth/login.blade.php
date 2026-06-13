<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - Darussalam Kost</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #e5e7eb;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .wrapper-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .main-card {
            background-color: #ffffff;
            border-radius: 0px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            overflow: hidden;
        }
        .left-banner {
            background-color: #2b5ae4;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            padding: 4rem 3rem;
            text-align: center;
            position: relative;
        }
        .vector-illustration {
            width: 100%;
            max-width: 280px;
            height: auto;
            margin-bottom: auto;
            margin-top: auto;
            opacity: 0.9;
        }
        .right-form-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem 4rem;
            background-color: #ffffff;
        }
        .app-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 1.25rem;
            color: #0f172a;
            margin-bottom: 3rem;
        }
        .brand-dot {
            width: 16px;
            height: 16px;
            border: 4px solid #2b5ae4;
            border-radius: 50%;
        }
        .form-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }
        .form-subtitle {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 2rem;
        }
        .form-floating {
            margin-bottom: 1rem;
        }
        .form-control {
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            padding: 1rem 0.75rem;
            font-size: 0.9rem;
            color: #0f172a;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            background-color: #ffffff;
            border-color: #2b5ae4;
            box-shadow: none;
        }
        .form-floating > label {
            padding: 1rem 0.75rem;
            color: #94a3b8;
            font-size: 0.9rem;
        }
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            transform: scale(0.85) translateY(-0.75rem) translateX(0.15rem);
            color: #2b5ae4 !important;
        }
        .action-buttons-group {
            display: flex;
            gap: 12px;
            margin-top: 1.5rem;
            margin-bottom: 2rem;
        }
        .btn-main-action {
            flex: 1;
            border-radius: 4px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 0.9rem;
            background-color: #2b5ae4;
            border: 1px solid #2b5ae4;
            color: #ffffff;
            transition: all 0.2s ease;
        }
        .btn-main-action:hover {
            background-color: #1e40af;
            border-color: #1e40af;
        }
        .btn-secondary-action {
            flex: 1;
            border-radius: 4px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 0.9rem;
            background-color: #ffffff;
            border: 1px solid #2b5ae4;
            color: #2b5ae4;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-secondary-action:hover {
            background-color: #f8fafc;
            color: #1e40af;
            border-color: #1e40af;
        }
        .social-login-footer {
            margin-top: auto;
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="wrapper-container">
    <div class="row g-0 main-card">

        <div class="col-lg-5 d-none d-lg-flex left-banner">
            <svg class="vector-illustration" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="80" fill="#3b6bf1"/>
                <rect x="60" y="70" width="80" height="70" rx="6" fill="#ffffff"/>
                <rect x="90" y="110" width="20" height="30" fill="#2b5ae4"/>
                <rect x="70" y="85" width="20" height="15" rx="2" fill="#cbd5e1"/>
                <rect x="110" y="85" width="20" height="15" rx="2" fill="#cbd5e1"/>
                <path d="M50 80 L100 40 L150 80" stroke="#ffffff" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="text-center w-100">
                <h3 class="fw-bold mb-2" style="font-size: 1.5rem; letter-spacing: -0.5px;">Akses Instan</h3>
                <p class="small mb-0" style="color: #bfdbfe; font-weight: 400; line-height: 1.5;">
                    Silakan masuk untuk mengelola pemesanan kamar, memantau riwayat pembayaran, atau mengajukan laporan pemeliharaan fasilitas kos Anda.
                </p>
            </div>
        </div>

        <div class="col-lg-7 col-12 right-form-panel">

            <div class="app-brand">
                <div class="brand-dot"></div>
                Darussalam Kost
            </div>

            <h2 class="form-title">Selamat Datang</h2>
            <p class="form-subtitle">Masukkan alamat email dan kata sandi akun kos Anda.</p>

            @if (session('success'))
                <div class="alert alert-success p-3 small border-0 mb-4" style="border-radius: 4px; background-color: #f0fdf4; color: #166534; font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger p-3 small border-0 mb-4" style="border-radius: 4px; background-color: #fef2f2; color: #991b1b; font-weight: 500;">
                    <ul class="mb-0 px-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-floating">
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="floatingInput"
                           placeholder="Alamat Email"
                           value="{{ old('email') }}"
                           required autofocus>
                    <label for="floatingInput">Alamat Email</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="floatingPassword"
                           placeholder="Password"
                           required>
                    <label for="floatingPassword">Password</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center my-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="checkDefault" style="cursor: pointer;">
                        <label class="form-check-label text-secondary small" for="checkDefault" style="cursor: pointer; user-select: none;">
                            Ingat saya di perangkat ini
                        </label>
                    </div>
                </div>

                <div class="action-buttons-group">
                    <button class="btn btn-main-action" type="submit">
                        Masuk Aplikasi
                    </button>
                    <a href="{{ route('register') }}" class="btn btn-secondary-action">
                        Buat Akun Baru
                    </a>
                </div>
            </form>

            <div class="social-login-footer">
                &copy; {{ date('Y') }} Platform Hunian Terintegrasi - Darussalam Kost
            </div>

        </div>
    </div>
</div>

</body>
</html>