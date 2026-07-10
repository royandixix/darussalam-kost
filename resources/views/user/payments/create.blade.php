@extends('user.layouts.app')

@section('title', 'Upload Bukti Pembayaran')

@section('page_header', 'Upload Bukti Pembayaran')

@section('page_subtitle', 'Pilih booking, pilih metode pembayaran, lalu kirim data pembayaran kamu')

@section('content')

<div class="section">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Form Pembayaran
                </h2>

                <p class="text-dark mb-0">
                    Pilih metode pembayaran. Jika memilih QRIS, gambar QRIS akan langsung muncul.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.payments.index') }}" class="btn btn-outline-primary py-3 px-4">
                    Kembali ke Pembayaran
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                <div class="box-feature h-100">
                    <span class="flaticon-building"></span>

                    <h3 class="mb-4">
                        Informasi Pembayaran
                    </h3>

                    <div id="bank_info" class="d-none">
                        <h5 class="text-primary mb-3">
                            Transfer Bank
                        </h5>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Bank
                            </span>

                            <strong>
                                BCA / BRI / Mandiri
                            </strong>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Nomor Rekening
                            </span>

                            <h4 class="text-primary mb-0">
                                1234567890
                            </h4>
                        </div>

                        <div>
                            <span class="d-block text-black-50">
                                Atas Nama
                            </span>

                            <strong>
                                Kosan Darussalam
                            </strong>
                        </div>
                    </div>

                    <div id="qris_info" class="d-none">
                        <h5 class="text-primary mb-3">
                            Scan QRIS
                        </h5>

                        <p class="text-dark">
                            Silakan scan QRIS berikut, lalu upload bukti pembayaran.
                        </p>

                        @if(file_exists(public_path('images/qris.png')))
                            <img src="{{ asset('images/qris.png') }}" alt="QRIS" class="img-fluid mb-3">
                        @else
                            <div class="alert alert-warning mb-0">
                                QRIS belum tersedia. Simpan gambar QRIS di:
                                <br>
                                <strong>public/images/qris.png</strong>
                            </div>
                        @endif
                    </div>

                    <div id="cod_info" class="d-none">
                        <h5 class="text-primary mb-3">
                            COD / Bayar di Tempat
                        </h5>

                        <p class="text-dark mb-0">
                            Pembayaran dilakukan langsung di tempat. Kamu tidak perlu upload bukti pembayaran.
                        </p>
                    </div>

                    <div id="payment_empty_info">
                        <h5 class="text-primary mb-3">
                            Pilih Metode Pembayaran
                        </h5>

                        <p class="text-dark mb-0">
                            Informasi pembayaran akan tampil setelah kamu memilih metode pembayaran.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="box-feature h-100">

                    <span class="flaticon-house"></span>

                    <h3 class="mb-4">
                        Data Pembayaran
                    </h3>

                    @if ($bookings->isEmpty())

                        <div class="text-center py-4">
                            <h4 class="text-primary mb-3">
                                Tidak Ada Booking yang Bisa Dibayar
                            </h4>

                            <p class="text-dark mb-4">
                                Pastikan kamu sudah melakukan booking kamar dan belum mengirim data pembayaran.
                            </p>

                            <a href="{{ route('user.rooms.index') }}" class="btn btn-primary text-white py-3 px-4">
                                Cari Kamar
                            </a>
                        </div>

                    @else

                        <form action="{{ route('user.payments.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Pilih Booking
                                </label>

                                <select name="booking_id" class="form-select" required>
                                    <option value="">-- Pilih Booking --</option>

                                    @foreach ($bookings as $booking)
                                        <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                            Booking #{{ $booking->id }} - Kamar {{ $booking->room->room_number ?? '-' }} - Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Metode Pembayaran
                                </label>

                                <select name="payment_method" id="payment_method" class="form-select" required>
                                    <option value="">-- Pilih Metode --</option>

                                    <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>
                                        Transfer Bank
                                    </option>

                                    <option value="qris" {{ old('payment_method') === 'qris' ? 'selected' : '' }}>
                                        QRIS
                                    </option>

                                    <option value="cod" {{ old('payment_method') === 'cod' ? 'selected' : '' }}>
                                        COD / Bayar di Tempat
                                    </option>
                                </select>
                            </div>

                            <div id="sender_area">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Nama Pengirim
                                    </label>

                                    <input 
                                        type="text" 
                                        name="sender_name" 
                                        id="sender_name"
                                        class="form-control" 
                                        value="{{ old('sender_name') }}" 
                                        placeholder="Contoh: Siti Nurhalizah"
                                    >
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Bank / Aplikasi Pengirim
                                    </label>

                                    <input 
                                        type="text" 
                                        name="sender_bank" 
                                        id="sender_bank"
                                        class="form-control" 
                                        value="{{ old('sender_bank') }}" 
                                        placeholder="Contoh: BCA, BRI, DANA, GoPay, ShopeePay"
                                    >
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Upload Bukti Pembayaran
                                    </label>

                                    <input 
                                        type="file" 
                                        name="payment_proof" 
                                        id="payment_proof"
                                        class="form-control" 
                                        accept="image/*"
                                    >

                                    <small class="text-black-50">
                                        Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                                    </small>
                                </div>
                            </div>

                            <div id="cod_area" class="alert alert-info d-none">
                                Kamu memilih COD / Bayar di Tempat. Bukti pembayaran tidak wajib diupload.
                            </div>

                            <div class="d-flex flex-column flex-sm-row gap-2">
                                <button type="submit" class="btn btn-primary text-white py-3 px-4">
                                    Kirim Data Pembayaran
                                </button>

                                <a href="{{ route('user.payments.index') }}" class="btn btn-outline-primary py-3 px-4">
                                    Batal
                                </a>
                            </div>
                        </form>

                    @endif

                </div>
            </div>

        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentMethod = document.getElementById('payment_method');
        const senderArea = document.getElementById('sender_area');
        const codArea = document.getElementById('cod_area');
        const senderName = document.getElementById('sender_name');
        const paymentProof = document.getElementById('payment_proof');

        const bankInfo = document.getElementById('bank_info');
        const qrisInfo = document.getElementById('qris_info');
        const codInfo = document.getElementById('cod_info');
        const paymentEmptyInfo = document.getElementById('payment_empty_info');

        function hidePaymentInfo() {
            bankInfo.classList.add('d-none');
            qrisInfo.classList.add('d-none');
            codInfo.classList.add('d-none');
            paymentEmptyInfo.classList.add('d-none');
        }

        function updatePaymentForm() {
            if (!paymentMethod) {
                return;
            }

            hidePaymentInfo();

            if (paymentMethod.value === 'bank_transfer') {
                bankInfo.classList.remove('d-none');
                senderArea.classList.remove('d-none');
                codArea.classList.add('d-none');

                senderName.setAttribute('required', 'required');
                paymentProof.setAttribute('required', 'required');
            }

            if (paymentMethod.value === 'qris') {
                qrisInfo.classList.remove('d-none');
                senderArea.classList.remove('d-none');
                codArea.classList.add('d-none');

                senderName.setAttribute('required', 'required');
                paymentProof.setAttribute('required', 'required');
            }

            if (paymentMethod.value === 'cod') {
                codInfo.classList.remove('d-none');
                senderArea.classList.add('d-none');
                codArea.classList.remove('d-none');

                senderName.removeAttribute('required');
                paymentProof.removeAttribute('required');
            }

            if (paymentMethod.value === '') {
                paymentEmptyInfo.classList.remove('d-none');
                senderArea.classList.remove('d-none');
                codArea.classList.add('d-none');

                senderName.removeAttribute('required');
                paymentProof.removeAttribute('required');
            }
        }

        if (paymentMethod) {
            paymentMethod.addEventListener('change', updatePaymentForm);
            updatePaymentForm();
        }
    });
</script>
@endpush