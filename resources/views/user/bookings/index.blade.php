@extends('user.layouts.app')

@section('title', 'Booking Saya')

@section('hide_page_header', true)

@section('content')

<div class="section" style="padding-top: 140px;">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Booking Saya
                </h2>

                <p class="text-dark mb-0">
                    Daftar pemesanan kamar yang sudah kamu ajukan di Darussalam Kost.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.rooms.index') }}" class="btn btn-primary text-white py-3 px-4">
                    Cari Kamar Lagi
                </a>
            </div>
        </div>

        <div class="row">

            @forelse($bookings as $booking)

                <div class="col-12 mb-4">
                    <div class="box-feature">

                        <div class="row align-items-center">

                            <div class="col-12 col-lg-2 mb-3 mb-lg-0">
                                <span class="d-block text-black-50 mb-1">
                                    Kode Booking
                                </span>

                                <h3 class="mb-0">
                                    #{{ $booking->id }}
                                </h3>
                            </div>

                            <div class="col-12 col-lg-2 mb-3 mb-lg-0">
                                <span class="d-block text-black-50 mb-1">
                                    Kamar
                                </span>

                                <strong>
                                    Kamar {{ $booking->room->room_number ?? '-' }}
                                </strong>
                            </div>

                            <div class="col-12 col-lg-2 mb-3 mb-lg-0">
                                <span class="d-block text-black-50 mb-1">
                                    Tanggal Masuk
                                </span>

                                <strong>
                                    {{ $booking->check_in_date ? $booking->check_in_date->format('d M Y') : '-' }}
                                </strong>
                            </div>

                            <div class="col-12 col-lg-2 mb-3 mb-lg-0">
                                <span class="d-block text-black-50 mb-1">
                                    Lama Sewa
                                </span>

                                <strong>
                                    {{ $booking->duration_month ?? '-' }} bulan
                                </strong>
                            </div>

                            <div class="col-12 col-lg-2 mb-3 mb-lg-0">
                                <span class="d-block text-black-50 mb-1">
                                    Total Biaya
                                </span>

                                <strong>
                                    Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                                </strong>
                            </div>

                            <div class="col-12 col-lg-2 mb-3 mb-lg-0 text-lg-end">
                                <span class="d-block text-black-50 mb-1">
                                    Status
                                </span>

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

                        <hr>

                        <div class="row align-items-center">
                            <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                                <div class="row">
                                    <div class="col-12 col-md-4 mb-3 mb-md-0">
                                        <span class="d-block text-black-50">
                                            Tanggal Booking
                                        </span>

                                        <strong>
                                            {{ $booking->created_at->format('d M Y') }}
                                        </strong>
                                    </div>

                                    <div class="col-12 col-md-4 mb-3 mb-md-0">
                                        <span class="d-block text-black-50">
                                            Kapasitas
                                        </span>

                                        <strong>
                                            {{ $booking->room->capacity ?? '-' }} orang
                                        </strong>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <span class="d-block text-black-50">
                                            Ukuran Kamar
                                        </span>

                                        <strong>
                                            {{ $booking->room->size ?? '-' }} m²
                                        </strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-4 text-lg-end">
                                <a href="{{ route('user.bookings.show', $booking) }}" class="btn btn-primary py-2 px-3">
                                    Lihat Detail
                                </a>

                                @if($booking->payment && $booking->payment->status === 'rejected')
                                    <a href="{{ route('user.payments.create') }}" class="btn btn-outline-primary py-2 px-3">
                                        Upload Ulang
                                    </a>
                                @elseif(!$booking->payment)
                                    <a href="{{ route('user.payments.create') }}" class="btn btn-outline-primary py-2 px-3">
                                        Upload Bukti
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            @empty

                <div class="col-12">
                    <div class="box-feature text-center">
                        <span class="flaticon-house"></span>

                        <h3 class="mb-3">
                            Belum Ada Booking
                        </h3>

                        <p class="text-dark mb-4">
                            Kamu belum mengajukan pemesanan kamar. Silakan cari kamar yang tersedia terlebih dahulu.
                        </p>

                        <a href="{{ route('user.rooms.index') }}" class="btn btn-primary text-white py-3 px-4">
                            Cari Kamar Sekarang
                        </a>
                    </div>
                </div>

            @endforelse

        </div>

    </div>
</div>

@endsection