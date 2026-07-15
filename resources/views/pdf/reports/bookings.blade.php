@extends('pdf.layout')

@section('content')
    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-label">Total Pemesanan</div>
                <div class="summary-value">{{ $records->count() }}</div>
            </td>

            <td>
                <div class="summary-label">Menunggu</div>
                <div class="summary-value">
                    {{ $records->where('status', 'pending')->count() }}
                </div>
            </td>

            <td>
                <div class="summary-label">Disetujui</div>
                <div class="summary-value">
                    {{ $records->where('status', 'approved')->count() }}
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
            Belum terdapat data pemesanan.
        </div>
    @else
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 4%">No.</th>
                    <th style="width: 7%">Kode</th>
                    <th style="width: 15%">Penghuni</th>
                    <th style="width: 8%">Kamar</th>
                    <th style="width: 11%">Tanggal Masuk</th>
                    <th style="width: 8%">Durasi</th>
                    <th style="width: 14%">Total</th>
                    <th style="width: 14%">Pembayaran</th>
                    <th style="width: 12%">Booking</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">#{{ $record->id }}</td>
                        <td>{{ $record->user?->name ?? '-' }}</td>
                        <td class="text-center">
                            {{ $record->room?->room_number ?? '-' }}
                        </td>
                        <td class="text-center">
                            {{ optional($record->check_in_date)->format('d/m/Y') ?? '-' }}
                        </td>
                        <td class="text-center">
                            {{ $record->duration_month }} bulan
                        </td>
                        <td class="text-right">
                            Rp{{ number_format($record->total_price, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            {{ match ($record->payment?->status) {
                                'verified' => 'Terverifikasi',
                                'rejected' => 'Ditolak',
                                'pending' => 'Menunggu',
                                default => 'Belum Ada',
                            } }}
                        </td>
                        <td class="text-center">
                            {{ match ($record->status) {
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'completed' => 'Selesai',
                                default => 'Menunggu',
                            } }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection