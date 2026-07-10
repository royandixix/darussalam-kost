@extends('user.layouts.app')

@section('title', 'Buat Laporan Perbaikan')

@section('hide_page_header', true)

@section('content')

<div class="section" style="padding-top: 140px;">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Buat Laporan Perbaikan
                </h2>

                <p class="text-dark mb-0">
                    Laporkan kerusakan fasilitas atau kamar agar dapat segera dicek oleh admin dan teknisi.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.maintenance.index') }}" class="btn btn-outline-primary py-3 px-4">
                    Kembali ke Laporan
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                <div class="box-feature h-100">
                    <span class="flaticon-house-3"></span>

                    <h3 class="mb-4">
                        Panduan Laporan
                    </h3>

                    <div class="mb-4">
                        <strong>
                            1. Pilih Kamar
                        </strong>

                        <p class="text-dark mb-0">
                            Pilih kamar yang mengalami kerusakan atau membutuhkan perbaikan.
                        </p>
                    </div>

                    <div class="mb-4">
                        <strong>
                            2. Isi Judul Kerusakan
                        </strong>

                        <p class="text-dark mb-0">
                            Tulis judul singkat seperti lampu rusak, air bocor, pintu macet, atau fasilitas bermasalah.
                        </p>
                    </div>

                    <div class="mb-4">
                        <strong>
                            3. Jelaskan Deskripsi
                        </strong>

                        <p class="text-dark mb-0">
                            Berikan detail kerusakan agar admin dan teknisi lebih mudah memahami kondisi kamar.
                        </p>
                    </div>

                    <div>
                        <strong>
                            4. Tunggu Konfirmasi
                        </strong>

                        <p class="text-dark mb-0">
                            Setelah laporan dikirim, status laporan akan diproses oleh admin atau teknisi.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="box-feature h-100">
                    <span class="flaticon-building"></span>

                    <h3 class="mb-4">
                        Form Laporan Kerusakan
                    </h3>

                    <form action="{{ route('user.maintenance.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Kamar
                            </label>

                            <select
                                name="room_id"
                                class="form-control @error('room_id') is-invalid @enderror"
                                required
                            >
                                <option value="">Pilih Kamar</option>

                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        Kamar {{ $room->room_number }}
                                    </option>
                                @endforeach
                            </select>

                            @error('room_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Judul Kerusakan
                            </label>

                            <input
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Contoh: Lampu kamar rusak"
                                required
                            >

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Deskripsi Kerusakan
                            </label>

                            <textarea
                                name="description"
                                rows="5"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Jelaskan kerusakan secara detail"
                                required
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-primary text-white py-3 px-4">
                                Kirim Laporan
                            </button>

                            <a href="{{ route('user.maintenance.index') }}" class="btn btn-outline-primary py-3 px-4">
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