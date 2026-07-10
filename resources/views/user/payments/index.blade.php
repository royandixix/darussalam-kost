@extends('user.layouts.app')

@section('title', 'Pembayaran Saya')

@section('hide_page_header', true)

@section('content')

<style>
    .payment-page {
        background: #f8fbfb;
    }

    .payment-toolbar {
        background: #ffffff;
        border: 1px solid #e7eeee;
        padding: 22px 24px;
        margin-bottom: 24px;
    }

    .transaction-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .transaction-item {
        background: #ffffff;
        border: 1px solid #e7eeee;
        padding: 20px 22px;
        transition: 0.2s ease;
    }

    .transaction-item:hover {
        box-shadow: 0 12px 28px rgba(0, 85, 85, 0.08);
        transform: translateY(-2px);
    }

    .transaction-icon {
        width: 46px;
        height: 46px;
        background: #eaf6f6;
        color: #005555;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .transaction-code {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .transaction-meta {
        font-size: 13px;
        color: #7a8b8b;
    }

    .transaction-amount {
        font-size: 22px;
        font-weight: 800;
        color: #005555;
        line-height: 1.2;
        text-align: right;
    }

    .transaction-detail {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #eef3f3;
    }

    .transaction-label {
        display: block;
        font-size: 12px;
        color: #7a8b8b;
        margin-bottom: 4px;
    }

    .transaction-value {
        display: block;
        font-size: 14px;
        color: #1f2937;
        font-weight: 700;
    }

    .transaction-proof {
        width: 54px;
        height: 54px;
        object-fit: cover;
        border: 1px solid #e7eeee;
        background: #f8fbfb;
    }

    .transaction-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #eef3f3;
    }

    @media (max-width: 991px) {
        .transaction-detail {
            grid-template-columns: repeat(2, 1fr);
        }

        .transaction-amount {
            text-align: left;
            font-size: 20px;
        }
    }

    @media (max-width: 575px) {
        .payment-toolbar {
            padding: 20px;
        }

        .transaction-item {
            padding: 18px;
        }

        .transaction-detail {
            grid-template-columns: 1fr;
        }

        .transaction-action {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="section payment-page" style="padding-top: 140px;">
    <div class="container">

        <div class="payment-toolbar">
            <div class="row align-items-center">
                <div class="col-12 col-lg-7 mb-3 mb-lg-0">
                    <h2 class="font-weight-bold text-primary heading mb-2">
                        Riwayat Pembayaran
                    </h2>

                    <p class="text-dark mb-0">
                        Lihat daftar transaksi pembayaran kamar, status verifikasi, dan bukti pembayaran yang sudah dikirim.
                    </p>
                </div>

                <div class="col-12 col-lg-5 text-lg-end">
                    <a href="{{ route('user.payments.create') }}" class="btn btn-primary text-white py-2 px-4">
                        Upload Bukti Pembayaran
                    </a>
                </div>
            </div>
        </div>

        <div class="transaction-list">

            @forelse ($payments as $payment)

                <div class="transaction-item">

                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                        <div class="d-flex align-items-center gap-3">
                            <div class="transaction-icon">
                                @if($payment->payment_method === 'qris')
                                    QRIS
                                @elseif($payment->payment_method === 'bank_transfer')
                                    TF
                                @elseif($payment->payment_method === 'cod')
                                    COD
                                @else
                                    PAY
                                @endif
                            </div>

                            <div>
                                <div class="transaction-code">
                                    PAY-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}
                                </div>

                                <div class="transaction-meta">
                                    Booking #{{ $payment->booking->id ?? '-' }} · Kamar {{ $payment->booking->room->room_number ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="transaction-amount mb-2">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </div>

                            <div class="text-lg-end">
                                @if($payment->status === 'pending')
                                    <span class="badge bg-warning text-dark rounded-0">
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($payment->status === 'verified')
                                    <span class="badge bg-success rounded-0">
                                        Berhasil
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
                    </div>

                    <div class="transaction-detail">
                        <div>
                            <span class="transaction-label">
                                Metode
                            </span>

                            <span class="transaction-value">
                                @if($payment->payment_method === 'qris')
                                    QRIS
                                @elseif($payment->payment_method === 'bank_transfer')
                                    Transfer Bank
                                @elseif($payment->payment_method === 'cod')
                                    COD
                                @else
                                    -
                                @endif
                            </span>
                        </div>

                        <div>
                            <span class="transaction-label">
                                Pengirim
                            </span>

                            <span class="transaction-value">
                                @if($payment->payment_method === 'cod')
                                    Bayar di Tempat
                                @elseif($payment->payment_method === 'qris')
                                    QRIS
                                @else
                                    {{ $payment->sender_name ?? '-' }}
                                @endif
                            </span>
                        </div>

                        <div>
                            <span class="transaction-label">
                                Bank / Aplikasi
                            </span>

                            <span class="transaction-value">
                                @if($payment->payment_method === 'cod')
                                    -
                                @elseif($payment->payment_method === 'qris')
                                    QRIS
                                @else
                                    {{ $payment->sender_bank ?? '-' }}
                                @endif
                            </span>
                        </div>

                        <div>
                            <span class="transaction-label">
                                Tanggal
                            </span>

                            <span class="transaction-value">
                                {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y H:i') : '-' }}
                            </span>
                        </div>
                    </div>

                    @if($payment->note)
                        <div class="alert alert-light border rounded-0 mt-3 mb-0">
                            <strong class="d-block mb-1">
                                Catatan Admin
                            </strong>

                            <p class="text-dark mb-0">
                                {{ $payment->note }}
                            </p>
                        </div>
                    @endif

                    <div class="transaction-action">
                        <div class="d-flex align-items-center gap-3">
                            @if($payment->payment_proof)
                                <img 
                                    src="{{ asset('storage/' . $payment->payment_proof) }}" 
                                    alt="Bukti Pembayaran"
                                    class="transaction-proof"
                                >

                                <div>
                                    <span class="d-block transaction-label">
                                        Bukti Pembayaran
                                    </span>

                                    <span class="transaction-value">
                                        Tersedia
                                    </span>
                                </div>
                            @else
                                <div>
                                    <span class="d-block transaction-label">
                                        Bukti Pembayaran
                                    </span>

                                    <span class="transaction-value">
                                        @if($payment->payment_method === 'cod')
                                            Tidak diperlukan
                                        @else
                                            Belum ada
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            @if($payment->payment_proof)
                                <button 
                                    type="button" 
                                    class="btn btn-primary py-2 px-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#paymentProofModal{{ $payment->id }}"
                                >
                                    Lihat Bukti
                                </button>
                            @else
                                @if($payment->payment_method === 'cod')
                                    <button type="button" class="btn btn-outline-primary py-2 px-3" disabled>
                                        COD
                                    </button>
                                @else
                                    <button type="button" class="btn btn-outline-primary py-2 px-3" disabled>
                                        Bukti Tidak Ada
                                    </button>
                                @endif
                            @endif

                            @if($payment->status === 'rejected')
                                <a href="{{ route('user.payments.create') }}" class="btn btn-outline-primary py-2 px-3">
                                    Upload Ulang
                                </a>
                            @endif
                        </div>
                    </div>

                </div>

                @if($payment->payment_proof)
                    <div class="modal fade" id="paymentProofModal{{ $payment->id }}" tabindex="-1" aria-labelledby="paymentProofModalLabel{{ $payment->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content rounded-0">
                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title" id="paymentProofModalLabel{{ $payment->id }}">
                                            Bukti Pembayaran PAY-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}
                                        </h5>

                                        <small class="text-muted">
                                            Booking #{{ $payment->booking->id ?? '-' }} - Kamar {{ $payment->booking->room->room_number ?? '-' }}
                                        </small>
                                    </div>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>

                                <div class="modal-body text-center">
                                    <img 
                                        src="{{ asset('storage/' . $payment->payment_proof) }}" 
                                        alt="Bukti Pembayaran"
                                        class="img-fluid"
                                        style="max-height: 75vh;"
                                    >
                                </div>

                                <div class="modal-footer">
                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="btn btn-primary text-white py-2 px-4">
                                        Buka Gambar
                                    </a>

                                    <button type="button" class="btn btn-outline-primary py-2 px-4" data-bs-dismiss="modal">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @empty

                <div class="box-feature text-center">
                    <span class="flaticon-building"></span>

                    <h3 class="mb-3">
                        Belum Ada Pembayaran
                    </h3>

                    <p class="text-dark mb-4">
                        Kamu belum memiliki transaksi pembayaran. Setelah melakukan booking kamar, transaksi akan tampil di halaman ini.
                    </p>

                    <a href="{{ route('user.rooms.index') }}" class="btn btn-primary text-white py-3 px-4 mb-2">
                        Cari Kamar
                    </a>

                    <a href="{{ route('user.payments.create') }}" class="btn btn-outline-primary py-3 px-4 mb-2">
                        Upload Bukti
                    </a>
                </div>

            @endforelse

        </div>

    </div>
</div>

@endsection