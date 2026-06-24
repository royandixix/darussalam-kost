@extends('user.layouts.app')

@section('title','Booking Saya')

@section('page_header','Data Booking')

@section('page_subtitle','Daftar booking kamar kamu')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kamar</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($bookings as $key => $booking)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $booking->room->room_number ?? '-' }}</td>
                        <td>{{ $booking->created_at->format('d-m-Y') }}</td>
                        <td>
                            <span class="badge bg-dark">
                                {{ $booking->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Belum ada booking
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@endsection