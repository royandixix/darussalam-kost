@extends('user.layouts.app')

@section('title', 'Detail Booking')

@section('page_header', 'Detail Booking')

@section('page_subtitle', 'Informasi lengkap pemesanan kamar kamu')

@section('content')

<div class="section">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Detail Booking #{{ $booking->id }}
                </h2>

                <p class="text-dark mb-0">
                    Lihat informasi kamar, status booking, pembayaran, dan feedback untuk pemesanan ini.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.bookings.index') }}" class="btn btn-outline-primary py-3 px-4">
                    Kembali ke Booking
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-lg-4 mb-4">
                <div class="box-feature h-100">

                    @if($booking->room?->photo)
                        <img 
                            src="{{ asset('storage/' . $booking->room->photo) }}" 
                            alt="Kamar {{ $booking->room->room_number }}"
                            class="img-fluid mb-4"
                        >
                    @else
                        <span class="flaticon-house"></span>
                    @endif

                    <h3 class="mb-3">
                        Kamar {{ $booking->room->room_number ?? '-' }}
                    </h3>

                    <div class="mb-3">
                        <span class="d-block text-black-50">
                            Harga Per Bulan
                        </span>

                        <strong>
                            Rp {{ number_format($booking->room->price ?? 0, 0, ',', '.') }}
                        </strong>
                    </div>

                    <div class="mb-3">
                        <span class="d-block text-black-50">
                            Kapasitas
                        </span>

                        <strong>
                            {{ $booking->room->capacity ?? '-' }} orang
                        </strong>
                    </div>

                    <div class="mb-3">
                        <span class="d-block text-black-50">
                            Ukuran
                        </span>

                        <strong>
                            {{ $booking->room->size ?? '-' }} m²
                        </strong>
                    </div>

                    <div>
                        <span class="d-block text-black-50">
                            Fasilitas
                        </span>

                        <p class="text-dark mb-0">
                            {{ $booking->room->facilities ?? '-' }}
                        </p>
                    </div>

                </div>
            </div>

            <div class="col-12 col-lg-8 mb-4">
                <div class="box-feature h-100">

                    <span class="flaticon-building"></span>

                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                        <div>
                            <h3 class="mb-1">
                                Informasi Booking
                            </h3>

                            <p class="text-dark mb-0">
                                Data pemesanan kamar yang sudah kamu ajukan.
                            </p>
                        </div>

                        <div>
                            @if($booking->status === 'pending')
                                <span class="badge bg-warning text-dark rounded-0">
                                    Menunggu
                                </span>
                            @elseif($booking->status === 'approved')
                                <span class="badge bg-success rounded-0">
                                    Disetujui
                                </span>
                            @elseif($booking->status === 'rejected')
                                <span class="badge bg-danger rounded-0">
                                    Ditolak
                                </span>
                            @elseif($booking->status === 'completed')
                                <span class="badge bg-primary rounded-0">
                                    Selesai
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-0">
                                    {{ $booking->status }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-12 col-md-6 mb-4">
                            <span class="d-block text-black-50">
                                Tanggal Masuk
                            </span>

                            <strong>
                                {{ $booking->check_in_date ? $booking->check_in_date->format('d M Y') : '-' }}
                            </strong>
                        </div>

                        <div class="col-12 col-md-6 mb-4">
                            <span class="d-block text-black-50">
                                Lama Sewa
                            </span>

                            <strong>
                                {{ $booking->duration_month }} bulan
                            </strong>
                        </div>

                        <div class="col-12 col-md-6 mb-4">
                            <span class="d-block text-black-50">
                                Total Biaya
                            </span>

                            <h4 class="text-primary mb-0">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </h4>
                        </div>

                        <div class="col-12 col-md-6 mb-4">
                            <span class="d-block text-black-50">
                                Tanggal Booking
                            </span>

                            <strong>
                                {{ $booking->created_at->format('d M Y H:i') }}
                            </strong>
                        </div>

                    </div>

                    <hr>

                    <h3 class="mb-4">
                        Informasi Pembayaran
                    </h3>

                    @if($booking->payment)

                        <div class="row">

                            <div class="col-12 col-md-6 mb-4">
                                <span class="d-block text-black-50">
                                    Metode Pembayaran
                                </span>

                                <strong>
                                    @if($booking->payment->payment_method === 'bank_transfer')
                                        Transfer Bank
                                    @elseif($booking->payment->payment_method === 'qris')
                                        QRIS
                                    @elseif($booking->payment->payment_method === 'cod')
                                        COD / Bayar di Tempat
                                    @else
                                        -
                                    @endif
                                </strong>
                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <span class="d-block text-black-50">
                                    Status Pembayaran
                                </span>

                                @if($booking->payment->status === 'pending')
                                    <span class="badge bg-warning text-dark rounded-0">
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($booking->payment->status === 'verified')
                                    <span class="badge bg-success rounded-0">
                                        Terverifikasi
                                    </span>
                                @elseif($booking->payment->status === 'rejected')
                                    <span class="badge bg-danger rounded-0">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-0">
                                        {{ $booking->payment->status }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <span class="d-block text-black-50">
                                    Nama Pengirim
                                </span>

                                <strong>
                                    {{ $booking->payment->sender_name ?? '-' }}
                                </strong>
                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <span class="d-block text-black-50">
                                    Bank / Aplikasi Pengirim
                                </span>

                                <strong>
                                    {{ $booking->payment->sender_bank ?? '-' }}
                                </strong>
                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <span class="d-block text-black-50">
                                    Tanggal Pembayaran
                                </span>

                                <strong>
                                    {{ $booking->payment->payment_date ? $booking->payment->payment_date->format('d M Y H:i') : '-' }}
                                </strong>
                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <span class="d-block text-black-50">
                                    Bukti Pembayaran
                                </span>

                                @if($booking->payment->payment_proof)
                                    <a href="{{ asset('storage/' . $booking->payment->payment_proof) }}" target="_blank" class="btn btn-primary py-2 px-3">
                                        Lihat Bukti
                                    </a>
                                @else
                                    <span class="badge bg-secondary rounded-0">
                                        Tidak Ada Bukti
                                    </span>
                                @endif
                            </div>

                        </div>

                        @if($booking->payment->note)
                            <div class="mb-4">
                                <span class="d-block text-black-50">
                                    Catatan Admin
                                </span>

                                <p class="text-dark mb-0">
                                    {{ $booking->payment->note }}
                                </p>
                            </div>
                        @endif

                        @if($booking->payment->status === 'rejected')
                            <a href="{{ route('user.payments.create') }}" class="btn btn-outline-primary py-3 px-4">
                                Upload Ulang Pembayaran
                            </a>
                        @endif

                    @else

                        <div class="text-center py-4">
                            <h4 class="text-primary mb-3">
                                Belum Ada Pembayaran
                            </h4>

                            <p class="text-dark mb-4">
                                Booking ini belum memiliki data pembayaran.
                            </p>

                            <a href="{{ route('user.payments.create') }}" class="btn btn-primary text-white py-3 px-4">
                                Upload Bukti Pembayaran
                            </a>
                        </div>

                    @endif

                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-12">
                <div class="box-feature">

                    <span class="flaticon-house-1"></span>

                    <h3 class="mb-4">
                        Feedback Booking
                    </h3>

                    @if($booking->feedback)

                        <div class="mb-3">
                            <span class="d-block text-black-50 mb-2">
                                Rating
                            </span>

                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $booking->feedback->rating)
                                    <span class="icon-star text-warning"></span>
                                @else
                                    <span class="icon-star text-black-50"></span>
                                @endif
                            @endfor

                            <strong class="ms-2">
                                {{ $booking->feedback->rating }}/5
                            </strong>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Komentar
                            </span>

                            <p class="text-dark mb-0">
                                {{ $booking->feedback->comment }}
                            </p>
                        </div>

                        <div>
                            <span class="d-block text-black-50">
                                Tanggal Feedback
                            </span>

                            <strong>
                                {{ $booking->feedback->created_at->format('d M Y') }}
                            </strong>
                        </div>

                    @else

                        <p class="text-dark mb-4">
                            Kamu belum memberikan feedback untuk booking ini.
                        </p>

                        @if(in_array($booking->status, ['approved', 'completed']))
                            <a href="{{ route('user.feedback.create') }}" class="btn btn-primary text-white py-3 px-4">
                                Beri Feedback
                            </a>
                        @else
                            <button type="button" class="btn btn-outline-primary py-3 px-4" disabled>
                                Feedback Belum Tersedia
                            </button>
                        @endif

                    @endif

                </div>
            </div>

        </div>

    </div>
</div>

@endsection