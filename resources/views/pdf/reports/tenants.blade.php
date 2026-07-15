@extends('pdf.layout')

@section('content')
    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-label">Total Penghuni</div>
                <div class="summary-value">{{ $records->count() }}</div>
            </td>

            <td>
                <div class="summary-label">Penghuni Aktif</div>
                <div class="summary-value">
                    {{ $records->where('status', 'active')->count() }}
                </div>
            </td>

            <td>
                <div class="summary-label">Tidak Aktif</div>
                <div class="summary-value">
                    {{ $records->where('status', 'inactive')->count() }}
                </div>
            </td>

            <td>
                <div class="summary-label">Kamar Ditempati</div>
                <div class="summary-value">
                    {{ $records->where('status', 'active')->pluck('room_id')->unique()->count() }}
                </div>
            </td>
        </tr>
    </table>

    @if ($records->isEmpty())
        <div class="empty-state">
            Belum terdapat data penghuni.
        </div>
    @else
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 4%">No.</th>
                    <th style="width: 8%">Booking</th>
                    <th style="width: 18%">Nama</th>
                    <th style="width: 14%">Telepon</th>
                    <th style="width: 20%">Email</th>
                    <th style="width: 8%">Kamar</th>
                    <th style="width: 14%">Tanggal Masuk</th>
                    <th style="width: 10%">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            {{ $record->booking_id ? '#' . $record->booking_id : '-' }}
                        </td>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->phone }}</td>
                        <td>{{ $record->email ?: '-' }}</td>
                        <td class="text-center">
                            {{ $record->room?->room_number ?? '-' }}
                        </td>
                        <td class="text-center">
                            {{ optional($record->check_in_date)->format('d/m/Y') ?? '-' }}
                        </td>
                        <td class="text-center">
                            {{ $record->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection