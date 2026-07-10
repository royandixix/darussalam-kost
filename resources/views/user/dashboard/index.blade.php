@extends('user.layouts.app')

@section('title', 'Dashboard Penghuni')

@section('hide_page_header', true)

@section('content')

<div class="section" style="padding-top: 140px;">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading mb-3">
                    Selamat Datang, {{ $user->name ?? auth()->user()->name }}
                </h2>

                <p class="text-dark mb-0">
                    Kelola kamar, booking, pembayaran, laporan perbaikan, dan feedback penghuni melalui Dashboard Darussalam Kost.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.rooms.index') }}" class="btn btn-primary text-white py-3 px-4 mb-2">
                    Lihat Kamar Tersedia
                </a>

                <a href="{{ route('user.bookings.index') }}" class="btn btn-outline-primary py-3 px-4 mb-2">
                    Lihat Sewa Saya
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="box-feature h-100">
                    <span class="flaticon-house"></span>

                    <h3 class="mb-3">
                        {{ $totalBookings ?? 0 }}
                    </h3>

                    <p class="mb-2">
                        Total Booking
                    </p>

                    <p class="text-dark">
                        {{ $pendingBookings ?? 0 }} booking menunggu konfirmasi.
                    </p>

                    <p>
                        <a href="{{ route('user.bookings.index') }}" class="learn-more">
                            Lihat Booking
                        </a>
                    </p>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="box-feature h-100">
                    <span class="flaticon-building"></span>

                    <h3 class="mb-3">
                        {{ $totalPayments ?? 0 }}
                    </h3>

                    <p class="mb-2">
                        Pembayaran
                    </p>

                    <p class="text-dark">
                        {{ $verifiedPayments ?? 0 }} pembayaran sudah terverifikasi.
                    </p>

                    <p>
                        <a href="{{ route('user.payments.index') }}" class="learn-more">
                            Lihat Pembayaran
                        </a>
                    </p>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="box-feature h-100">
                    <span class="flaticon-house-3"></span>

                    <h3 class="mb-3">
                        {{ $totalMaintenance ?? 0 }}
                    </h3>

                    <p class="mb-2">
                        Laporan Perbaikan
                    </p>

                    <p class="text-dark">
                        {{ $completedMaintenance ?? 0 }} laporan perbaikan selesai.
                    </p>

                    <p>
                        <a href="{{ route('user.maintenance.index') }}" class="learn-more">
                            Lihat Perbaikan
                        </a>
                    </p>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="box-feature h-100">
                    <span class="flaticon-house-1"></span>

                    <h3 class="mb-3">
                        {{ $totalFeedback ?? 0 }}
                    </h3>

                    <p class="mb-2">
                        Feedback
                    </p>

                    <p class="text-dark">
                        Masukan dan penilaian yang sudah kamu kirim.
                    </p>

                    <p>
                        <a href="{{ route('user.feedback.index') }}" class="learn-more">
                            Lihat Feedback
                        </a>
                    </p>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="section bg-light">
    <div class="container">

        <div class="row justify-content-center text-center mb-5">
            <div class="col-12 col-lg-8">
                <h2 class="font-weight-bold heading text-primary mb-4">
                    Diagram Status Penghuni
                </h2>

                <p class="text-dark mb-0">
                    Pantau alur booking, pembayaran, dan laporan perbaikan kamu secara mudah melalui dashboard ini.
                </p>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-lg-4 mb-4">
                <div class="box-feature h-100">
                    <span class="flaticon-house"></span>

                    <h3 class="mb-3">
                        Booking
                    </h3>

                    <div class="mb-3">
                        <strong>1. Booking Diajukan</strong>
                        <p class="text-dark mb-0">
                            Penghuni memilih kamar dan mengajukan sewa.
                        </p>
                    </div>

                    <div class="mb-3">
                        <strong>2. Dicek Admin</strong>
                        <p class="text-dark mb-0">
                            Admin memeriksa data booking penghuni.
                        </p>
                    </div>

                    <div class="mb-4">
                        <strong>3. Disetujui</strong>
                        <p class="text-dark mb-0">
                            {{ $approvedBookings ?? 0 }} dari {{ $totalBookings ?? 0 }} booking disetujui.
                        </p>
                    </div>

                    <a href="{{ route('user.bookings.index') }}" class="btn btn-primary py-2 px-3">
                        Lihat Booking
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-4 mb-4">
                <div class="box-feature h-100">
                    <span class="flaticon-building"></span>

                    <h3 class="mb-3">
                        Pembayaran
                    </h3>

                    <div class="mb-3">
                        <strong>1. Pilih Metode</strong>
                        <p class="text-dark mb-0">
                            Penghuni memilih Transfer Bank, QRIS, atau COD.
                        </p>
                    </div>

                    <div class="mb-3">
                        <strong>2. Kirim Pembayaran</strong>
                        <p class="text-dark mb-0">
                            Transfer dan QRIS wajib upload bukti.
                        </p>
                    </div>

                    <div class="mb-4">
                        <strong>3. Terverifikasi</strong>
                        <p class="text-dark mb-0">
                            {{ $verifiedPayments ?? 0 }} dari {{ $totalPayments ?? 0 }} pembayaran terverifikasi.
                        </p>
                    </div>

                    <a href="{{ route('user.payments.index') }}" class="btn btn-primary py-2 px-3">
                        Lihat Pembayaran
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-4 mb-4">
                <div class="box-feature h-100">
                    <span class="flaticon-house-3"></span>

                    <h3 class="mb-3">
                        Perbaikan
                    </h3>

                    <div class="mb-3">
                        <strong>1. Laporan Dibuat</strong>
                        <p class="text-dark mb-0">
                            Penghuni membuat laporan kerusakan kamar.
                        </p>
                    </div>

                    <div class="mb-3">
                        <strong>2. Ditangani Teknisi</strong>
                        <p class="text-dark mb-0">
                            Teknisi melakukan pengecekan dan perbaikan.
                        </p>
                    </div>

                    <div class="mb-4">
                        <strong>3. Selesai</strong>
                        <p class="text-dark mb-0">
                            {{ $completedMaintenance ?? 0 }} dari {{ $totalMaintenance ?? 0 }} laporan selesai.
                        </p>
                    </div>

                    <a href="{{ route('user.maintenance.index') }}" class="btn btn-primary py-2 px-3">
                        Lihat Perbaikan
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="section">
    <div class="container">

        <div class="row">

            <div class="col-12 col-lg-8 mb-5 mb-lg-0">
                <div class="box-feature h-100">
                    <div class="row align-items-center mb-4">
                        <div class="col-12 col-md-8 mb-3 mb-md-0">
                            <h2 class="font-weight-bold text-primary heading mb-2">
                                Aktivitas Terbaru
                            </h2>

                            <p class="text-dark mb-0">
                                Riwayat aktivitas terbaru dari akun penghuni kamu.
                            </p>
                        </div>

                        <div class="col-12 col-md-4 text-md-end">
                            <span class="badge bg-primary rounded-0">
                                {{ count($activities ?? []) }} aktivitas
                            </span>
                        </div>
                    </div>

                    @forelse($activities ?? [] as $activity)
                        <div class="mb-4">
                            <h3 class="mb-1">
                                {{ $activity['title'] }}
                            </h3>

                            <p class="text-dark mb-1">
                                {{ $activity['description'] }}
                            </p>

                            <small class="text-black-50">
                                {{ isset($activity['date']) ? $activity['date']->format('d M Y') : '-' }}
                            </small>
                        </div>
                    @empty
                        <div class="text-center">
                            <h4 class="text-primary mb-3">
                                Belum Ada Aktivitas
                            </h4>

                            <p class="text-dark mb-4">
                                Aktivitas booking, pembayaran, perbaikan, dan feedback akan muncul di sini.
                            </p>

                            <a href="{{ route('user.rooms.index') }}" class="btn btn-primary py-3 px-4">
                                Mulai Cari Kamar
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-12 col-lg-4">

                <div class="box-feature mb-4">
                    <span class="flaticon-house"></span>

                    <h3 class="mb-3">
                        {{ $approvedBookings ?? 0 }} Booking Disetujui
                    </h3>

                    <p class="text-dark mb-0">
                        Booking yang sudah disetujui oleh admin.
                    </p>
                </div>

                <div class="box-feature mb-4">
                    <span class="flaticon-building"></span>

                    <h3 class="mb-3">
                        {{ $verifiedPayments ?? 0 }} Pembayaran Terverifikasi
                    </h3>

                    <p class="text-dark mb-0">
                        Pembayaran yang sudah dicek dan diterima oleh admin.
                    </p>
                </div>

                <div class="box-feature">
                    <span class="flaticon-house-3"></span>

                    <h3 class="mb-3">
                        {{ $completedMaintenance ?? 0 }} Perbaikan Selesai
                    </h3>

                    <p class="text-dark mb-0">
                        Laporan kerusakan yang sudah selesai ditangani.
                    </p>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection