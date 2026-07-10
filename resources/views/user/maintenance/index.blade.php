@extends('user.layouts.app')

@section('title', 'Laporan Perbaikan')

@section('hide_page_header', true)

@section('content')

<div class="section" style="padding-top: 140px;">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Riwayat Laporan Perbaikan
                </h2>

                <p class="text-dark mb-0">
                    Pantau laporan kerusakan kamar yang sudah kamu kirim, mulai dari status menunggu, ditugaskan, diproses, sampai selesai.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.maintenance.create') }}" class="btn btn-primary text-white py-3 px-4">
                    Buat Laporan Baru
                </a>
            </div>
        </div>

        <div class="row">

            @forelse ($reports as $report)

                <div class="col-12 col-md-6 col-xl-4 mb-4">
                    <div class="box-feature h-100">

                        @if ($report->photo)
                            <div class="mb-4">
                                <img 
                                    src="{{ asset('storage/' . $report->photo) }}" 
                                    alt="{{ $report->title }}"
                                    class="img-fluid w-100"
                                >
                            </div>
                        @else
                            <span class="flaticon-house-3"></span>
                        @endif

                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3 flex-wrap">
                            <div>
                                <span class="d-block text-black-50 mb-1">
                                    Laporan #{{ $report->id }}
                                </span>

                                <h3 class="mb-0">
                                    {{ $report->title }}
                                </h3>
                            </div>

                            <div>
                                @if ($report->status === 'completed')
                                    <span class="badge bg-success rounded-0">
                                        Selesai
                                    </span>
                                @elseif ($report->status === 'in_progress')
                                    <span class="badge bg-info rounded-0">
                                        Diproses
                                    </span>
                                @elseif ($report->status === 'assigned')
                                    <span class="badge bg-primary rounded-0">
                                        Ditugaskan
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-0">
                                        Menunggu
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Kamar
                            </span>

                            <strong>
                                Kamar {{ $report->room?->room_number ?? '-' }}
                            </strong>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Prioritas
                            </span>

                            @if ($report->priority === 'high')
                                <span class="badge bg-danger rounded-0">
                                    Tinggi
                                </span>
                            @elseif ($report->priority === 'medium')
                                <span class="badge bg-warning text-dark rounded-0">
                                    Sedang
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-0">
                                    Rendah
                                </span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Deskripsi
                            </span>

                            <p class="text-dark mb-0">
                                {{ \Illuminate\Support\Str::limit($report->description, 120) }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <span class="d-block text-black-50">
                                Tanggal Laporan
                            </span>

                            <strong>
                                {{ $report->created_at->format('d M Y') }}
                            </strong>
                        </div>

                        <div>
                            @if ($report->status === 'pending')
                                <p class="text-dark mb-0">
                                    Laporan kamu sedang menunggu pengecekan admin.
                                </p>
                            @elseif ($report->status === 'assigned')
                                <p class="text-dark mb-0">
                                    Laporan sudah ditugaskan ke teknisi.
                                </p>
                            @elseif ($report->status === 'in_progress')
                                <p class="text-dark mb-0">
                                    Laporan sedang dalam proses perbaikan.
                                </p>
                            @elseif ($report->status === 'completed')
                                <p class="text-dark mb-0">
                                    Laporan perbaikan sudah selesai ditangani.
                                </p>
                            @endif
                        </div>

                    </div>
                </div>

            @empty

                <div class="col-12">
                    <div class="box-feature text-center">
                        <span class="flaticon-house-3"></span>

                        <h3 class="mb-3">
                            Belum Ada Laporan
                        </h3>

                        <p class="text-dark mb-4">
                            Kamu belum pernah mengirim laporan perbaikan. Jika ada kerusakan kamar, silakan buat laporan baru.
                        </p>

                        <a href="{{ route('user.maintenance.create') }}" class="btn btn-primary text-white py-3 px-4">
                            Buat Laporan Sekarang
                        </a>
                    </div>
                </div>

            @endforelse

        </div>

    </div>
</div>

@endsection