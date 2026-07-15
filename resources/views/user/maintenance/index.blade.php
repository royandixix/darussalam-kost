@extends('user.layouts.app')

@section('title', 'Laporan Kerusakan')

@section('hide_page_header')
@endsection

@section('hide_page_footer')
@endsection

@push('styles')
<style>
    .maintenance-content {
        padding-top: 180px;
        padding-bottom: 40px;
    }

    @media (max-width: 991.98px) {
        .maintenance-content {
            padding-top: 140px;
        }
    }

    @media (max-width: 575.98px) {
        .maintenance-content {
            padding-top: 120px;
            padding-bottom: 30px;
        }

        .maintenance-header {
            align-items: flex-start !important;
        }

        .maintenance-header .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container maintenance-content">
    <div class="maintenance-header d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">Laporan Kerusakan</h2>

            <p class="text-muted mb-0">
                Pantau seluruh laporan kerusakan dan perkembangan perbaikannya.
            </p>
        </div>

        <a
            href="{{ route('user.maintenance.create') }}"
            class="btn btn-primary"
        >
            Buat Laporan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($reports->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <h5 class="mb-2">
                    Belum ada laporan kerusakan
                </h5>

                <p class="text-muted mb-3">
                    Silakan buat laporan apabila terdapat fasilitas yang mengalami kerusakan.
                </p>

                <a
                    href="{{ route('user.maintenance.create') }}"
                    class="btn btn-primary"
                >
                    Buat Laporan Pertama
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($reports as $report)
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
                                <div>
                                    <h5 class="mb-1">
                                        {{ $report->title }}
                                    </h5>

                                    <div class="text-muted small">
                                        Kamar {{ $report->room?->room_number ?? '-' }}
                                        •
                                        {{ $report->created_at?->format('d M Y H:i') ?? '-' }}
                                    </div>
                                </div>

                                <div class="d-flex gap-2 flex-wrap">
                                    <span class="badge bg-{{ match($report->priority) {
                                        'high' => 'danger',
                                        'medium' => 'warning text-dark',
                                        default => 'secondary',
                                    } }}">
                                        {{ match($report->priority) {
                                            'high' => 'Prioritas Tinggi',
                                            'medium' => 'Prioritas Sedang',
                                            default => 'Prioritas Rendah',
                                        } }}
                                    </span>

                                    <span class="badge bg-{{ match($report->status) {
                                        'completed' => 'success',
                                        'in_progress' => 'primary',
                                        'assigned' => 'info text-dark',
                                        default => 'secondary',
                                    } }}">
                                        {{ match($report->status) {
                                            'completed' => 'Selesai',
                                            'in_progress' => 'Sedang Dikerjakan',
                                            'assigned' => 'Ditugaskan',
                                            default => 'Menunggu',
                                        } }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="text-muted small mb-1">
                                    Deskripsi Kerusakan
                                </div>

                                <div>
                                    {{ $report->description }}
                                </div>
                            </div>

                            @if($report->photo)
                                <div class="mb-3">
                                    <div class="text-muted small mb-2">
                                        Foto Kerusakan
                                    </div>

                                    <img
                                        src="{{ asset('storage/' . $report->photo) }}"
                                        alt="Foto Kerusakan"
                                        class="img-fluid rounded border"
                                        style="max-height: 260px;"
                                    >
                                </div>
                            @endif

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="text-muted small mb-1">
                                        Teknisi
                                    </div>

                                    <div class="fw-semibold">
                                        {{ $report->assignedTechnician?->name ?? 'Belum ditugaskan' }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="text-muted small mb-1">
                                        Status Terakhir
                                    </div>

                                    <div class="fw-semibold">
                                        {{ match($report->status) {
                                            'completed' => 'Perbaikan selesai',
                                            'in_progress' => 'Sedang dalam proses perbaikan',
                                            'assigned' => 'Teknisi sudah ditugaskan',
                                            default => 'Menunggu penanganan admin',
                                        } }}
                                    </div>
                                </div>
                            </div>

                            @if($report->updates->isNotEmpty())
                                <div class="mt-4">
                                    <h6 class="mb-3">
                                        Riwayat Catatan Teknisi
                                    </h6>

                                    @foreach($report->updates->sortByDesc('created_at') as $update)
                                        <div class="border rounded p-3 mb-2 bg-light">
                                            <div class="d-flex justify-content-between gap-3 flex-wrap mb-2">
                                                <strong>
                                                    {{ $update->technician?->name ?? 'Teknisi' }}
                                                </strong>

                                                <small class="text-muted">
                                                    {{ $update->created_at?->format('d M Y H:i') ?? '-' }}
                                                </small>
                                            </div>

                                            <div class="mb-2">
                                                {{ $update->note }}
                                            </div>

                                            <span class="badge bg-{{ match($update->status) {
                                                'completed' => 'success',
                                                'in_progress' => 'primary',
                                                'assigned' => 'info text-dark',
                                                default => 'secondary',
                                            } }}">
                                                {{ match($update->status) {
                                                    'completed' => 'Selesai',
                                                    'in_progress' => 'Sedang Dikerjakan',
                                                    'assigned' => 'Ditugaskan',
                                                    default => ucfirst($update->status),
                                                } }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if($report->status === 'pending')
                                <div class="mt-3">
                                    <a
                                        href="{{ route('user.maintenance.edit', $report) }}"
                                        class="btn btn-outline-primary btn-sm"
                                    >
                                        Edit Laporan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection