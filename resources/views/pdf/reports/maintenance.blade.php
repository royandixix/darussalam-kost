@extends('pdf.layout')

@section('content')
    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-label">Total Laporan</div>
                <div class="summary-value">{{ $records->count() }}</div>
            </td>

            <td>
                <div class="summary-label">Menunggu</div>
                <div class="summary-value">
                    {{ $records->where('status', 'pending')->count() }}
                </div>
            </td>

            <td>
                <div class="summary-label">Diproses</div>
                <div class="summary-value">
                    {{ $records->whereIn('status', ['assigned', 'in_progress'])->count() }}
                </div>
            </td>

            <td>
                <div class="summary-label">Selesai</div>
                <div class="summary-value">
                    {{ $records->where('status', 'completed')->count() }}
                </div>
            </td>
        </tr>
    </table>

    @if ($records->isEmpty())
        <div class="empty-state">
            Belum terdapat laporan maintenance.
        </div>
    @else
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 4%">No.</th>
                    <th style="width: 13%">Penghuni</th>
                    <th style="width: 7%">Kamar</th>
                    <th style="width: 15%">Judul</th>
                    <th style="width: 25%">Deskripsi</th>
                    <th style="width: 12%">Teknisi</th>
                    <th style="width: 8%">Prioritas</th>
                    <th style="width: 9%">Status</th>
                    <th style="width: 12%">Tanggal</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $record->user?->name ?? '-' }}</td>
                        <td class="text-center">
                            {{ $record->room?->room_number ?? '-' }}
                        </td>
                        <td>{{ $record->title }}</td>
                        <td>{{ $record->description }}</td>
                        <td>
                            {{ $record->assignedTechnician?->name ?? 'Belum ditugaskan' }}
                        </td>
                        <td class="text-center">
                            {{ match ($record->priority) {
                                'low' => 'Rendah',
                                'high' => 'Tinggi',
                                default => 'Sedang',
                            } }}
                        </td>
                        <td class="text-center">
                            {{ match ($record->status) {
                                'assigned' => 'Ditugaskan',
                                'in_progress' => 'Dikerjakan',
                                'completed' => 'Selesai',
                                default => 'Menunggu',
                            } }}
                        </td>
                        <td class="text-center">
                            {{ optional($record->created_at)->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection