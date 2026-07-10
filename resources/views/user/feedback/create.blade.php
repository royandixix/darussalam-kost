@extends('user.layouts.app')

@section('title', 'Buat Feedback')

@section('hide_page_header', true)

@section('content')

<div class="section" style="padding-top: 140px;">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Buat Feedback
                </h2>

                <p class="text-dark mb-0">
                    Berikan penilaian dan masukan berdasarkan pengalaman kamu selama menggunakan layanan Darussalam Kost.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.feedback.index') }}" class="btn btn-outline-primary py-3 px-4">
                    Kembali ke Feedback
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                <div class="box-feature h-100">
                    <span class="flaticon-house"></span>

                    <h3 class="mb-4">
                        Panduan Feedback
                    </h3>

                    <div class="mb-4">
                        <strong>
                            1. Pilih Booking
                        </strong>

                        <p class="text-dark mb-0">
                            Pilih data booking kamar yang ingin kamu beri penilaian.
                        </p>
                    </div>

                    <div class="mb-4">
                        <strong>
                            2. Berikan Rating
                        </strong>

                        <p class="text-dark mb-0">
                            Pilih rating sesuai pengalaman kamu selama menggunakan layanan kost.
                        </p>
                    </div>

                    <div class="mb-4">
                        <strong>
                            3. Tulis Komentar
                        </strong>

                        <p class="text-dark mb-0">
                            Berikan komentar yang jelas agar pengelola dapat meningkatkan kualitas layanan.
                        </p>
                    </div>

                    <div>
                        <strong>
                            4. Kirim Feedback
                        </strong>

                        <p class="text-dark mb-0">
                            Feedback yang kamu kirim akan masuk ke sistem dan dapat ditinjau oleh admin.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="box-feature h-100">
                    <span class="flaticon-building"></span>

                    <h3 class="mb-4">
                        Form Feedback
                    </h3>

                    @if($bookings->isEmpty())

                        <div class="text-center py-4">
                            <h4 class="text-primary mb-3">
                                Belum Ada Booking yang Bisa Dinilai
                            </h4>

                            <p class="text-dark mb-4">
                                Feedback hanya bisa diberikan untuk booking yang sudah disetujui atau selesai dan belum pernah diberi feedback.
                            </p>

                            <a href="{{ route('user.bookings.index') }}" class="btn btn-primary text-white py-3 px-4">
                                Lihat Booking Saya
                            </a>
                        </div>

                    @else

                        <form action="{{ route('user.feedback.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Pilih Booking
                                </label>

                                <select
                                    name="booking_id"
                                    class="form-control rounded-0 @error('booking_id') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        Pilih Booking
                                    </option>

                                    @foreach($bookings as $booking)
                                        <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                            Booking #{{ $booking->id }} - Kamar {{ $booking->room->room_number ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('booking_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Rating
                                </label>

                                <select
                                    name="rating"
                                    class="form-control rounded-0 @error('rating') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        Pilih Rating
                                    </option>

                                    <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>
                                        ⭐⭐⭐⭐⭐ Sangat Puas
                                    </option>

                                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>
                                        ⭐⭐⭐⭐ Puas
                                    </option>

                                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>
                                        ⭐⭐⭐ Cukup
                                    </option>

                                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>
                                        ⭐⭐ Kurang
                                    </option>

                                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>
                                        ⭐ Buruk
                                    </option>
                                </select>

                                @error('rating')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Komentar
                                </label>

                                <textarea
                                    name="comment"
                                    rows="6"
                                    class="form-control rounded-0 @error('comment') is-invalid @enderror"
                                    placeholder="Tuliskan pengalaman kamu selama tinggal di Darussalam Kost..."
                                    required
                                >{{ old('comment') }}</textarea>

                                @error('comment')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex flex-column flex-sm-row gap-2">
                                <button type="submit" class="btn btn-primary text-white py-3 px-4">
                                    Kirim Feedback
                                </button>

                                <a href="{{ route('user.feedback.index') }}" class="btn btn-outline-primary py-3 px-4">
                                    Batal
                                </a>
                            </div>
                        </form>

                    @endif

                </div>
            </div>

        </div>

    </div>
</div>

@endsection