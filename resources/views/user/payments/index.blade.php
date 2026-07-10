@extends('user.layouts.app')

@section('title', 'Pembayaran Saya')

@section('page_header', 'Pembayaran Saya')

@section('page_subtitle', 'Riwayat bukti pembayaran dan status verifikasi kamu')

@section('content')

<div class="section">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Riwayat Pembayaran
                </h2>

                <p class="text-dark mb-0">
                    Pantau status pembayaran kamar kamu. Bukti pembayaran akan diverifikasi oleh admin.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.payments.create') }}" class="btn btn-primary text-white py-3 px-4">
                    Upload Bukti Pembayaran
                </a>
            </div>
        </div>

        <div class="row">

            @forelse ($payments as $payment)

                <div class="col-12 col-lg-6 mb-4">
                    <div class="box-feature h-100">

                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <span class="d-block text-black-50 mb-1">
                                    Kode Booking
                                </span>

                                <h3 class="mb-0">
                                    #{{ $payment->booking->id ?? '-' }}
                                </h3>
                            </div>

                            <div>
                                @if($payment->status === 'pending')
                                    <span class="badge bg-warning text-dark rounded-0">
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($payment->status === 'verified')
                                    <span class="badge bg-success rounded-0">
                                        Terverifikasi
                                    </span>
                                @elseif($payment->status === 'rejected')
                                    <span class="badge bg-danger rounded-0">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-0">
                                        {{ $payment->status }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <h2 class="text-primary mb-1">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </h2>

                            <span class="text-black-50">
                                Total pembayaran
                            </span>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Kamar
                            </span>

                            <strong>
                                Kamar {{ $payment->booking->room->room_number ?? '-' }}
                            </strong>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Metode Pembayaran
                            </span>

                            <strong>
                                @if($payment->payment_method === 'qris')
                                    QRIS
                                @elseif($payment->payment_method === 'bank_transfer')
                                    Transfer Bank
                                @elseif($payment->payment_method === 'cod')
                                    COD / Bayar di Tempat
                                @else
                                    -
                                @endif
                            </strong>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Nama Pengirim
                            </span>

                            <strong>
                                {{ $payment->sender_name ?? '-' }}
                            </strong>

                            @if($payment->sender_bank)
                                <div class="text-black-50">
                                    {{ $payment->sender_bank }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Tanggal Pembayaran
                            </span>

                            <strong>
                                {{ $payment->payment_date ? $payment->payment_date->format('d M Y H:i') : '-' }}
                            </strong>
                        </div>

                        @if($payment->note)
                            <div class="mb-4">
                                <span class="d-block text-black-50">
                                    Catatan Admin
                                </span>

                                <p class="text-dark mb-0">
                                    {{ $payment->note }}
                                </p>
                            </div>
                        @endif

                        <div class="d-flex flex-wrap gap-2 mt-4">
                            @if($payment->payment_proof)
                                <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="btn btn-primary py-2 px-3">
                                    Lihat Bukti
                                </a>
                            @else
                                <button type="button" class="btn btn-outline-primary py-2 px-3" disabled>
                                    Bukti Tidak Ada
                                </button>
                            @endif

                            @if($payment->status === 'rejected')
                                <a href="{{ route('user.payments.create') }}" class="btn btn-outline-primary py-2 px-3">
                                    Upload Ulang
                                </a>
                            @endif
                        </div>

                    </div>
                </div>

            @empty

                <div class="col-12">
                    <div class="box-feature text-center">
                        <span class="flaticon-building"></span>

                        <h3 class="mb-3">
                            Belum Ada Pembayaran
                        </h3>

                        <p class="text-dark mb-4">
                            Kamu belum mengupload bukti pembayaran. Setelah melakukan booking kamar, silakan upload bukti pembayaran melalui menu ini.
                        </p>

                        <a href="{{ route('user.rooms.index') }}" class="btn btn-primary text-white py-3 px-4">
                            Cari Kamar
                        </a>

                        <a href="{{ route('user.payments.create') }}" class="btn btn-outline-primary py-3 px-4">
                            Upload Bukti
                        </a>
                    </div>
                </div>

            @endforelse

        </div>

    </div>
</div>

@endsection