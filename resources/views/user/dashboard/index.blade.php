@extends('user.layouts.app')

@section('title', 'Dashboard Penghuni')

@section('content')

<section class="py-5">
    <div class="container">

        <div class="bg-info p-5 mb-5 text-white" style="border-radius:16px;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="fw-bold mb-3">
                        Selamat Datang, {{ $user->name ?? auth()->user()->name }}
                    </h1>

                    <p class="mb-4">
                        Kelola kamar, booking, pembayaran, laporan perbaikan, dan feedback penghuni melalui Dashboard Darussalam Kost.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('user.rooms.index') }}" class="btn btn-dark px-4">
                            Lihat Kamar Tersedia
                        </a>

                        <a href="{{ route('user.bookings.index') }}" class="btn btn-light px-4">
                            Lihat Sewa Saya
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 text-center mt-4 mt-lg-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="150"
                        height="150"
                        fill="currentColor"
                        class="text-dark opacity-75"
                        viewBox="0 0 16 16">
                        <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 2 8h1v6a1 1 0 0 0 1 1h3V9h2v6h3a1 1 0 0 0 1-1V8h1a.5.5 0 0 0 .354-.854z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">

            <div class="col-md-6 col-lg-3">
                <div class="card border h-100" style="border-radius:12px;border-color:#e9ecef;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-calendar-check fs-3 text-warning"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0">{{ $totalBookings ?? 0 }}</h4>
                                <small class="text-muted">Total Booking</small>
                                <div class="small text-muted">
                                    {{ $pendingBookings ?? 0 }} menunggu
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border h-100" style="border-radius:12px;border-color:#e9ecef;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-credit-card fs-3 text-success"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0">{{ $totalPayments ?? 0 }}</h4>
                                <small class="text-muted">Pembayaran</small>
                                <div class="small text-muted">
                                    {{ $verifiedPayments ?? 0 }} terverifikasi
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border h-100" style="border-radius:12px;border-color:#e9ecef;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-tools fs-3 text-danger"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0">{{ $totalMaintenance ?? 0 }}</h4>
                                <small class="text-muted">Laporan Perbaikan</small>
                                <div class="small text-muted">
                                    {{ $completedMaintenance ?? 0 }} selesai
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border h-100" style="border-radius:12px;border-color:#e9ecef;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-chat-left-text fs-3 text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0">{{ $totalFeedback ?? 0 }}</h4>
                                <small class="text-muted">Feedback</small>
                                <div class="small text-muted">
                                    Masukan terkirim
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4">

            <div class="col-lg-8">
                <div class="card border h-100" style="border-radius:12px;border-color:#e9ecef;">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Aktivitas Terbaru</h5>
                        <span class="badge bg-light text-dark">
                            {{ count($activities ?? []) }} aktivitas
                        </span>
                    </div>

                    <div class="card-body">

                        @forelse($activities ?? [] as $activity)
                            <div class="d-flex justify-content-between align-items-start border-bottom py-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <div class="bg-{{ $activity['color'] }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:42px;height:42px;">
                                            <i class="bi {{ $activity['icon'] }} text-{{ $activity['color'] }}"></i>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $activity['title'] }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $activity['description'] }}
                                        </small>
                                    </div>
                                </div>

                                <small class="text-muted text-nowrap ms-3">
                                    {{ $activity['date']->format('d M Y') }}
                                </small>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <h6 class="text-muted mt-3">Belum ada aktivitas terbaru</h6>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border h-100" style="border-radius:12px;border-color:#e9ecef;">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Ringkasan Status</h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold">Booking Disetujui</span>
                                <span>{{ $approvedBookings ?? 0 }}</span>
                            </div>
                            <div class="progress" style="height:8px;">
                                <div class="progress-bar bg-success"
                                    style="width: {{ ($totalBookings ?? 0) > 0 ? (($approvedBookings ?? 0) / $totalBookings) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold">Pembayaran Terverifikasi</span>
                                <span>{{ $verifiedPayments ?? 0 }}</span>
                            </div>
                            <div class="progress" style="height:8px;">
                                <div class="progress-bar bg-primary"
                                    style="width: {{ ($totalPayments ?? 0) > 0 ? (($verifiedPayments ?? 0) / $totalPayments) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold">Maintenance Selesai</span>
                                <span>{{ $completedMaintenance ?? 0 }}</span>
                            </div>
                            <div class="progress" style="height:8px;">
                                <div class="progress-bar bg-warning"
                                    style="width: {{ ($totalMaintenance ?? 0) > 0 ? (($completedMaintenance ?? 0) / $totalMaintenance) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection