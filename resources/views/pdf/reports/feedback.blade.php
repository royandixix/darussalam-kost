@extends('pdf.layout')

@section('content')
    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-label">Jumlah Feedback</div>
                <div class="summary-value">{{ $records->count() }}</div>
            </td>

            <td>
                <div class="summary-label">Rata-Rata Rating</div>
                <div class="summary-value">{{ $averageRating }}/5</div>
            </td>

            <td>
                <div class="summary-label">Rating Baik</div>
                <div class="summary-value">
                    {{ $records->where('rating', '>=', 4)->count() }}
                </div>
            </td>

            <td>
                <div class="summary-label">Dipublikasikan</div>
                <div class="summary-value">
                    {{ $records->where('is_published', true)->count() }}
                </div>
            </td>
        </tr>
    </table>

    @if ($records->isEmpty())
        <div class="empty-state">
            Belum terdapat feedback.
        </div>
    @else
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 5%">No.</th>
                    <th style="width: 18%">Penghuni</th>
                    <th style="width: 8%">Kamar</th>
                    <th style="width: 9%">Rating</th>
                    <th style="width: 42%">Komentar</th>
                    <th style="width: 9%">Publikasi</th>
                    <th style="width: 14%">Tanggal</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $record->user?->name ?? '-' }}</td>
                        <td class="text-center">
                            {{ $record->booking?->room?->room_number ?? '-' }}
                        </td>
                        <td class="text-center">
                            {{ $record->rating }}/5
                        </td>
                        <td>{{ $record->comment }}</td>
                        <td class="text-center">
                            {{ $record->is_published ? 'Ya' : 'Tidak' }}
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