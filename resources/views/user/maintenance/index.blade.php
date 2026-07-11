@extends('user.layouts.app')

@section('title', 'Laporan Perbaikan')

@section('hide_page_header', true)

@section('content')

<div class="section" style="padding-top: 140px;">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Laporan Perbaikan
                </h2>

                <p class="text-dark mb-0">
                    Pantau laporan kerusakan kamar dan fasilitas yang sudah kamu kirim.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.maintenance.create') }}" class="btn btn-primary text-white py-3 px-4">
                    Buat Laporan
                </a>
            </div>
        </div>

        <div class="row">

            @forelse($reports as $report)

                <div class="col-12 col-lg-6 mb-4">
                    <div class="box-feature h-100">

                        <div class="d-flex justify-content-between align-items-start gap-3 mb-4 flex-wrap">
                            <div>
                                <span class="d-block text-black-50 mb-1">
                                    Kamar
                                </span>

                                <h3 class="mb-0">
                                    Kamar {{ $report->room->room_number ?? '-' }}
                                </h3>
                            </div>

                            <div>
                                @if($report->status === 'pending')
                                    <span class="badge bg-warning text-dark rounded-0">
                                        Menunggu
                                    </span>
                                @elseif($report->status === 'assigned')
                                    <span class="badge bg-info rounded-0">
                                        Ditugaskan
                                    </span>
                                @elseif($report->status === 'in_progress')
                                    <span class="badge bg-primary rounded-0">
                                        Sedang Dikerjakan
                                    </span>
                                @elseif($report->status === 'completed')
                                    <span class="badge bg-success rounded-0">
                                        Selesai
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-0">
                                        {{ $report->status }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Judul Kerusakan
                            </span>

                            <strong>
                                {{ $report->title }}
                            </strong>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Deskripsi
                            </span>

                            <p class="text-dark mb-0">
                                {{ $report->description }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Prioritas
                            </span>

                            @if($report->priority === 'low')
                                <span class="badge bg-success rounded-0">
                                    Rendah
                                </span>
                            @elseif($report->priority === 'medium')
                                <span class="badge bg-warning text-dark rounded-0">
                                    Sedang
                                </span>
                            @elseif($report->priority === 'high')
                                <span class="badge bg-danger rounded-0">
                                    Tinggi
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-0">
                                    {{ $report->priority }}
                                </span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Tanggal Laporan
                            </span>

                            <strong>
                                {{ $report->created_at ? $report->created_at->format('d M Y H:i') : '-' }}
                            </strong>
                        </div>

                        @if($report->photo)
                            <div class="mb-4">
                                <span class="d-block text-black-50 mb-2">
                                    Foto Kerusakan
                                </span>

                                <img 
                                    src="{{ asset('storage/' . $report->photo) }}" 
                                    alt="Foto Kerusakan"
                                    class="img-fluid"
                                    style="max-height: 180px;"
                                >
                            </div>
                        @endif

                        <div class="d-flex flex-wrap gap-2 mt-4">
                            @if($report->photo)
                                <a href="{{ asset('storage/' . $report->photo) }}" target="_blank" class="btn btn-primary py-2 px-3">
                                    Lihat Foto
                                </a>
                            @endif

                            @if($report->status === 'pending')
                                <a href="{{ route('user.maintenance.edit', $report) }}" class="btn btn-outline-primary py-2 px-3">
                                    Edit Laporan
                                </a>
                            @endif
                        </div>

                    </div>
                </div>

            @empty

                <div class="col-12">
                    <div class="box-feature text-center">
                        <span class="flaticon-house-3"></span>

                        <h3 class="mb-3">
                            Belum Ada Laporan Perbaikan
                        </h3>

                        <p class="text-dark mb-4">
                            Kamu belum membuat laporan perbaikan. Jika ada kerusakan kamar atau fasilitas, silakan buat laporan baru.
                        </p>

                        <a href="{{ route('user.maintenance.create') }}" class="btn btn-primary text-white py-3 px-4">
                            Buat Laporan
                        </a>
                    </div>
                </div>

            @endforelse

        </div>

    </div>
</div>

@endsection