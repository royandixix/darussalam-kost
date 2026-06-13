<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Darussalam Kost</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            background: #e5e7eb;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .wrapper-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .main-card {
            background: #fff;
            border-radius: 0;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 100%;
            min-height: 600px;
            overflow: hidden;
        }

        .left-banner {
            background: #2b5ae4;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            text-align: center;
        }

        .right-form-panel {
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .app-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .brand-dot {
            width: 14px;
            height: 14px;
            border: 3px solid #2b5ae4;
            border-radius: 50%;
        }

        .form-title {
            font-size: 1.7rem;
            font-weight: 700;
        }

        .form-subtitle {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 2rem;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            padding: 0.9rem;
        }

        .form-control:focus {
            border-color: #2b5ae4;
            box-shadow: none;
        }

        .action-buttons-group {
            display: flex;
            gap: 12px;
            margin-top: 1.5rem;
        }

        .btn-main-action {
            flex: 1;
            background: #2b5ae4;
            border: none;
            color: #fff;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 6px;
        }

        .btn-main-action:hover {
            background: #1e40af;
        }

        .btn-secondary-action {
            flex: 1;
            border: 1px solid #2b5ae4;
            color: #2b5ae4;
            text-align: center;
            padding: 0.75rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            background: #fff;
        }

        .btn-secondary-action:hover {
            background: #f8fafc;
        }

        .alert {
            border-radius: 6px;
        }
    </style>
</head>

<body>

    <div class="wrapper-container">
        <div class="row g-0 main-card">

            {{-- LEFT SIDE --}}
            <div class="col-lg-5 d-none d-lg-flex left-banner">

                <svg width="140" height="140" fill="white" viewBox="0 0 16 16">
                    <path
                        d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 2 8h1v6a1 1 0 0 0 1 1h3V9h2v6h3a1 1 0 0 0 1-1V8h1a.5.5 0 0 0 .354-.854z" />
                </svg>

                <h4 class="mt-4 fw-bold">Hunian Nyaman</h4>
                <p class="small text-white-50">
                    Daftarkan akun untuk mulai booking kamar & pembayaran dengan mudah.
                </p>

            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-lg-7 col-12 right-form-panel">

                <div class="app-brand">
                    <div class="brand-dot"></div>
                    Darussalam Kost
                </div>

                <h2 class="form-title">Daftar Akun</h2>
                <p class="form-subtitle">Lengkapi data untuk membuat akun baru</p>

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap"
                            value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}" required>
                    </div>

                    <div class="form-floating">
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            id="floatingPhone" placeholder="No HP" value="{{ old('phone') }}" required>
                        <label for="floatingPhone">No HP</label>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="floatingAddress"
                            placeholder="Alamat" style="height: 100px" required>{{ old('address') }}</textarea>
                        <label for="floatingAddress">Alamat</label>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Konfirmasi Password" required>
                    </div>

                    <div class="action-buttons-group">
                        <button type="submit" class="btn btn-main-action">
                            Daftar
                        </button>

                        <a href="{{ route('login') }}" class="btn btn-secondary-action">
                            Login
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>

</body>

</html>
