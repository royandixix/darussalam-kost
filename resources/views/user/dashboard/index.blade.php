@extends('user.layouts.app')

@section('title', 'Dashboard Penghuni')

@section('content')

<section class="py-5">
    <div class="container">

        <div class="bg-info p-5 mb-5 text-white" style="border-radius:16px;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="fw-bold mb-3">
                        Selamat Datang, {{ auth()->user()->name }}
                    </h1>

                    <p class="mb-4">
                        Kelola kamar, booking, pembayaran, laporan pemeliharaan, dan seluruh aktivitas penghuni dengan lebih mudah melalui Dashboard Darussalam Kost.
                    </p>

                    <a href="{{ route('user.rooms.index') }}" class="btn btn-dark px-4">
                        Lihat Kamar Tersedia
                    </a>
                </div>

                <div class="col-lg-4 text-center mt-4 mt-lg-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="150"
                         height="150"
                         fill="currentColor"
                         class="text-dark"
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#f1a501" viewBox="0 0 16 16">
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v11a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0">{{ $totalBookings ?? 0 }}</h4>
                                <small class="text-muted">Total Booking</small>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#28a745" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4z"/>
                                    <path d="M0 6h16v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0">{{ $totalPayments ?? 0 }}</h4>
                                <small class="text-muted">Pembayaran</small>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#dc3545" viewBox="0 0 16 16">
                                    <path d="M9.405 1.05a1 1 0 0 0-1.81.584v2.24l-4.9 4.9a2 2 0 1 0 2.828 2.828l4.9-4.9h2.24a1 1 0 0 0 .584-1.81z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0">{{ $totalMaintenance ?? 0 }}</h4>
                                <small class="text-muted">Maintenance</small>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0d6efd" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 6.5-4 4a.5.5 0 0 1-.707 0l-2-2 .707-.707L7.146 9.44l3.647-3.647.707.707z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0">{{ $totalFeedback ?? 0 }}</h4>
                                <small class="text-muted">Feedback</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card border" style="border-radius:12px;border-color:#e9ecef;">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">Aktivitas Terbaru</h5>
            </div>

            <div class="card-body">

                @forelse($activities ?? [] as $activity)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <div>
                            <div class="fw-semibold">
                                {{ $activity['title'] }}
                            </div>
                            <small class="text-muted">
                                {{ $activity['date'] }}
                            </small>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="#adb5bd" viewBox="0 0 16 16">
                            <path d="M14 4.5V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4.5L8 8l6-3.5z"/>
                            <path d="M14 3H2a1 1 0 0 0-.8.4L8 7.5l6.8-4.1A1 1 0 0 0 14 3z"/>
                        </svg>
                        <h6 class="text-muted mt-3">Belum ada aktivitas terbaru</h6>
                    </div>
                @endforelse

            </div>
        </div>

    </div>
</section>

@endsection