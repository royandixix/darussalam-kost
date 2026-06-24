@extends('user.layouts.app')

@section('title', 'Pembayaran Saya')

@section('page_header')
    Pembayaran Saya
@endsection

@section('page_subtitle')
    Riwayat pembayaran sewa kamar
@endsection

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        @if($payments->count())
            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Booking</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Bayar</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($payments as $payment)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    Booking #{{ $payment->booking_id }}
                                </td>

                                <td>
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>

                                <td>

                                    @if($payment->status === 'verified')

                                        <span class="badge bg-success">
                                            Terverifikasi
                                        </span>

                                    @elseif($payment->status === 'rejected')

                                        <span class="badge bg-danger">
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">
                                            Menunggu
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $payment->payment_date
                                        ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y')
                                        : '-' }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>
        @else

            <div class="text-center py-5">

                <h5>Belum ada pembayaran</h5>

                <p class="text-muted">
                    Data pembayaran akan muncul di sini.
                </p>

            </div>

        @endif

    </div>
</div>

@endsection