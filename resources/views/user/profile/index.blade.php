@extends('user.layouts.app')

@section('title', 'Profil Saya')

@section('page_header', 'Profil Saya')

@section('page_subtitle', 'Informasi akun penghuni Darussalam Kost')

@section('content')

<div class="section">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Profil Penghuni
                </h2>

                <p class="text-dark mb-0">
                    Kelola informasi akun, kontak, dan data pribadi yang digunakan di aplikasi Darussalam Kost.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary py-3 px-4">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-lg-4 mb-4 mb-lg-0">
                <div class="box-feature h-100 text-center">

                    @if(auth()->user()->photo)
                        <img 
                            src="{{ asset('storage/' . auth()->user()->photo) }}" 
                            alt="{{ auth()->user()->name }}"
                            class="img-fluid mb-4"
                        >
                    @else
                        <span class="flaticon-house"></span>
                    @endif

                    <h3 class="mb-2">
                        {{ auth()->user()->name }}
                    </h3>

                    <p class="text-dark mb-3">
                        {{ auth()->user()->email }}
                    </p>

                    <span class="badge bg-primary rounded-0 mb-4">
                        {{ auth()->user()->role_label ?? 'Penghuni' }}
                    </span>

                    <div class="text-start mt-4">
                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Status Akun
                            </span>

                            <strong>
                                Aktif
                            </strong>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Nomor Telepon
                            </span>

                            <strong>
                                {{ auth()->user()->phone ?? '-' }}
                            </strong>
                        </div>

                        <div>
                            <span class="d-block text-black-50">
                                Alamat
                            </span>

                            <strong>
                                {{ auth()->user()->address ?? '-' }}
                            </strong>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="box-feature h-100">

                    <span class="flaticon-building"></span>

                    <h3 class="mb-4">
                        Informasi Akun
                    </h3>

                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-12 mb-4">
                                <label class="form-label fw-semibold">
                                    Nama Lengkap
                                </label>

                                <input 
                                    type="text" 
                                    name="name" 
                                    class="form-control" 
                                    value="{{ old('name', auth()->user()->name) }}"
                                    required
                                >
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-semibold">
                                    Alamat Email
                                </label>

                                <input 
                                    type="email" 
                                    class="form-control" 
                                    value="{{ auth()->user()->email }}"
                                    readonly
                                >

                                <small class="text-black-50">
                                    Email digunakan untuk login dan tidak dapat diubah dari halaman ini.
                                </small>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-semibold">
                                    Nomor Telepon
                                </label>

                                <input 
                                    type="text" 
                                    name="phone" 
                                    class="form-control" 
                                    value="{{ old('phone', auth()->user()->phone) }}"
                                    placeholder="Contoh: 081234567890"
                                >
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-semibold">
                                    Alamat
                                </label>

                                <textarea 
                                    name="address" 
                                    class="form-control" 
                                    rows="4"
                                    placeholder="Masukkan alamat lengkap"
                                >{{ old('address', auth()->user()->address) }}</textarea>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-semibold">
                                    Foto Profil
                                </label>

                                <input 
                                    type="file" 
                                    name="photo" 
                                    class="form-control" 
                                    accept="image/*"
                                >

                                <small class="text-black-50">
                                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                                </small>
                            </div>

                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-primary text-white py-3 px-4">
                                Simpan Perubahan
                            </button>

                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary py-3 px-4">
                                Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

@endsection