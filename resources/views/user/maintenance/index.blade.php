@extends('user.layouts.app')

@section('title', 'Laporan Perbaikan')

@section('page_header')
    Laporan Perbaikan
@endsection

@section('page_subtitle')
    Daftar laporan kerusakan yang pernah Anda kirim
@endsection

@section('content')
    <div class="mb-4 text-end">
        <a href="{{ route('user.maintenance.create') }}" class="btn btn-primary">
            + Buat Laporan
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($reports->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Kamar</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $report->title }}</td>
                                    <td>{{ $report->room?->room_number ?? '-' }}</td>
                                    <td>
                                        @if ($report->status === 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($report->status === 'in_progress')
                                            <span class="badge bg-info">Diproses</span>
                                        @elseif($report->status === 'assigned')
                                            <span class="badge bg-primary">Ditugaskan</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>{{ $report->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <h5>Belum ada laporan</h5>
                    <p class="text-muted mb-0">Anda belum pernah mengirim laporan perbaikan.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
