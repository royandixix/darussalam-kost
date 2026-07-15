@extends('pdf.layout')

@section('content')
    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-label">Total Transaksi</div>
                <div class="summary-value">{{ $records->count() }}</div>
            </td>

            <td>
                <div class="summary-label">Terverifikasi</div>
                <div class="summary-value">
                    {{ $records->where('status', 'verified')->count() }}
                </div>
            </td>

            <td>
                <div class="summary-label">Menunggu</div>
                <div class="summary-value">
                    {{ $records->where('status', 'pending')->count() }}
                </div>
            </td>

            <td>
                <div class="summary-label">Total Pendapatan</div>
                <div class="summary-value" style="font-size: 11px">
                    Rp{{ number_format($totalAmount, 0, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    @if ($records->isEmpty())
        <div class="empty-state">
            Belum terdapat data pembayaran.
        </div>
    @else
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 4%">No.</th>
                    <th style="width: 8%">Booking</th>
                    <th style="width: 18%">Penghuni</th>
                    <th style="width: 8%">Kamar</th>
                    <th style="width: 13%">Metode</th>
                    <th style="width: 15%">Jumlah</th>
                    <th style="width: 16%">Tanggal</th>
                    <th style="width: 13%">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            #{{ $record->booking_id }}
                        </td>
                        <td>{{ $record->booking?->user?->name ?? '-' }}</td>
                        <td class="text-center">
                            {{ $record->booking?->room?->room_number ?? '-' }}
                        </td>
                        <td class="text-center">
                            {{ match ($record->payment_method) {
                                'bank_transfer' => 'Transfer Bank',
                                'qris' => 'QRIS',
                                'cod' => 'COD',
                                default => '-',
                            } }}
                        </td>
                        <td class="text-right">
                            Rp{{ number_format($record->amount, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            {{ optional($record->payment_date)->format('d/m/Y H:i') ?? '-' }}
                        </td>
                        <td class="text-center">
                            {{ match ($record->status) {
                                'verified' => 'Terverifikasi',
                                'rejected' => 'Ditolak',
                                default => 'Menunggu',
                            } }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection