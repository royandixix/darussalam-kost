<div class="modal fade" id="roomModal{{ $room->id }}" tabindex="-1" aria-labelledby="roomModalLabel{{ $room->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-0">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="roomModalLabel{{ $room->id }}">
                        Detail Kamar {{ $room->room_number }}
                    </h5>

                    <small class="text-muted">
                        Lihat detail kamar, fasilitas, harga sewa, dan status ketersediaan kamar.
                    </small>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                        <img
                            src="{{ $room->photo ? asset('storage/' . $room->photo) : asset('property-1.0.0/images/img_1.jpg') }}"
                            alt="Kamar {{ $room->room_number }}"
                            class="img-fluid mb-4"
                        >

                        <div class="border p-4">
                            <h5 class="mb-3">
                                Informasi Kamar
                            </h5>

                            <div class="mb-3">
                                <span class="d-block text-muted">
                                    Nomor Kamar
                                </span>

                                <strong>
                                    {{ $room->room_number }}
                                </strong>
                            </div>

                            <div class="mb-3">
                                <span class="d-block text-muted">
                                    Harga Sewa
                                </span>

                                <strong class="text-primary">
                                    Rp {{ number_format($room->price, 0, ',', '.') }} / bulan
                                </strong>
                            </div>

                            <div class="mb-3">
                                <span class="d-block text-muted">
                                    Kapasitas
                                </span>

                                <strong>
                                    {{ $room->capacity ?? '-' }} orang
                                </strong>
                            </div>

                            <div class="mb-3">
                                <span class="d-block text-muted">
                                    Ukuran
                                </span>

                                <strong>
                                    {{ $room->size ?? '-' }} m²
                                </strong>
                            </div>

                            <div class="mb-3">
                                <span class="d-block text-muted">
                                    Status Kamar
                                </span>

                                @if($room->status === 'available')
                                    <span class="badge bg-success rounded-0">
                                        Tersedia
                                    </span>
                                @elseif($room->status === 'occupied')
                                    <span class="badge bg-warning text-dark rounded-0">
                                        Terisi
                                    </span>
                                @elseif($room->status === 'maintenance')
                                    <span class="badge bg-danger rounded-0">
                                        Perbaikan
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-0">
                                        {{ $room->status }}
                                    </span>
                                @endif
                            </div>

                            <div>
                                <span class="d-block text-muted">
                                    Fasilitas
                                </span>

                                <p class="text-dark mb-0">
                                    {{ $room->facilities ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7">
                        <div class="border p-4 h-100">

                            @if($room->status === 'available')

                                <h5 class="mb-4">
                                    Form Checkout Kamar
                                </h5>

                                <form
                                    action="{{ route('user.bookings.store') }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                    class="booking-checkout-form"
                                    data-room-id="{{ $room->id }}"
                                    data-room-price="{{ $room->price }}"
                                >
                                    @csrf

                                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                                    <div class="row">

                                        <div class="col-12 col-md-6 mb-4">
                                            <label class="form-label fw-semibold">
                                                Tanggal Masuk
                                            </label>

                                            <input
                                                type="date"
                                                name="check_in_date"
                                                class="form-control rounded-0"
                                                required
                                            >
                                        </div>

                                        <div class="col-12 col-md-6 mb-4">
                                            <label class="form-label fw-semibold">
                                                Lama Sewa
                                            </label>

                                            <input
                                                type="number"
                                                name="duration_month"
                                                class="form-control rounded-0 duration-input"
                                                min="1"
                                                value="1"
                                                required
                                            >
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="alert alert-light border rounded-0 mb-0">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <span class="d-block text-muted">
                                                            Harga Per Bulan
                                                        </span>

                                                        <strong class="text-primary monthly-price-text">
                                                            Rp {{ number_format($room->price, 0, ',', '.') }}
                                                        </strong>
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-3">
                                                        <span class="d-block text-muted">
                                                            Lama Kontrak
                                                        </span>

                                                        <strong class="text-dark contract-duration-text">
                                                            1 Bulan
                                                        </strong>
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                                                        <span class="d-block text-muted">
                                                            Total Estimasi Kontrak
                                                        </span>

                                                        <strong class="text-dark contract-total-text">
                                                            Rp {{ number_format($room->price, 0, ',', '.') }}
                                                        </strong>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <span class="d-block text-muted">
                                                            Pembayaran Awal
                                                        </span>

                                                        <strong class="text-primary initial-payment-text">
                                                            Rp {{ number_format($room->price, 0, ',', '.') }}
                                                        </strong>

                                                        <small class="d-block text-muted">
                                                            Dibayar saat booking sebagai biaya bulan pertama.
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <label class="form-label fw-semibold">
                                                Metode Pembayaran
                                            </label>

                                            <select
                                                name="payment_method"
                                                class="form-control rounded-0 payment-method-select"
                                                required
                                            >
                                                <option value="bank_transfer">Transfer Bank</option>
                                                <option value="qris">QRIS</option>
                                                <option value="cod">COD / Bayar di Tempat</option>
                                            </select>
                                        </div>

                                        <div class="col-12 bank-transfer-area">
                                            <div class="alert alert-light border rounded-0">
                                                <strong class="d-block mb-2">
                                                    Rekening Tujuan
                                                </strong>

                                                <p class="text-dark mb-1">
                                                    Bank: <strong>BCA</strong>
                                                </p>

                                                <p class="text-dark mb-1">
                                                    No. Rekening: <strong>827351492608</strong>
                                                </p>

                                                <p class="text-dark mb-0">
                                                    Atas Nama: <strong>Kosan Darussalam</strong>
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-semibold">
                                                    Nama Pengirim
                                                </label>

                                                <input
                                                    type="text"
                                                    name="sender_name"
                                                    class="form-control rounded-0 bank-sender-name"
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
                                                    class="form-control rounded-0 bank-sender-bank"
                                                    placeholder="Contoh: BCA, BRI, Mandiri, DANA, OVO"
                                                >
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-semibold">
                                                    Upload Bukti Transfer
                                                </label>

                                                <input
                                                    type="file"
                                                    name="payment_proof"
                                                    class="form-control rounded-0 bank-payment-proof payment-proof-preview-input"
                                                    accept="image/*"
                                                    data-preview-wrapper="bankPreviewWrapper{{ $room->id }}"
                                                    data-preview-image="bankPreviewImage{{ $room->id }}"
                                                    data-preview-name="bankPreviewName{{ $room->id }}"
                                                >
                                            </div>

                                            <div class="mb-4 d-none" id="bankPreviewWrapper{{ $room->id }}">
                                                <label class="form-label fw-semibold">
                                                    Preview Bukti Transfer
                                                </label>

                                                <div class="border p-3">
                                                    <img
                                                        src=""
                                                        alt="Preview Bukti Transfer"
                                                        class="img-fluid mb-3"
                                                        id="bankPreviewImage{{ $room->id }}"
                                                        style="max-height: 280px;"
                                                    >

                                                    <div class="text-muted" id="bankPreviewName{{ $room->id }}"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 qris-info-area d-none">
                                            <div class="alert alert-light border rounded-0">
                                                <strong class="d-block mb-3">
                                                    Scan QRIS Pembayaran
                                                </strong>

                                                <div class="text-center">
                                                    <img
                                                        src="{{ asset('images/qris.png') }}"
                                                        alt="QRIS Pembayaran"
                                                        class="img-fluid"
                                                        style="max-height: 320px;"
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 qris-upload-area d-none">
                                            <div class="mb-4">
                                                <label class="form-label fw-semibold">
                                                    Nama Pengirim QRIS
                                                </label>

                                                <input
                                                    type="text"
                                                    name="sender_name"
                                                    class="form-control rounded-0 qris-sender-name"
                                                    placeholder="Contoh: Siti Nurhalizah"
                                                >
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-semibold">
                                                    Upload Bukti Pembayaran QRIS
                                                </label>

                                                <input
                                                    type="file"
                                                    name="payment_proof"
                                                    class="form-control rounded-0 qris-payment-proof payment-proof-preview-input"
                                                    accept="image/*"
                                                    data-preview-wrapper="qrisPreviewWrapper{{ $room->id }}"
                                                    data-preview-image="qrisPreviewImage{{ $room->id }}"
                                                    data-preview-name="qrisPreviewName{{ $room->id }}"
                                                >
                                            </div>

                                            <div class="mb-4 d-none" id="qrisPreviewWrapper{{ $room->id }}">
                                                <label class="form-label fw-semibold">
                                                    Preview Bukti QRIS
                                                </label>

                                                <div class="border p-3">
                                                    <img
                                                        src=""
                                                        alt="Preview Bukti QRIS"
                                                        class="img-fluid mb-3"
                                                        id="qrisPreviewImage{{ $room->id }}"
                                                        style="max-height: 280px;"
                                                    >

                                                    <div class="text-muted" id="qrisPreviewName{{ $room->id }}"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 cod-info-area d-none">
                                            <div class="alert alert-light border rounded-0">
                                                <strong class="d-block mb-2">
                                                    Pembayaran COD
                                                </strong>

                                                <p class="text-dark mb-0">
                                                    Pembayaran awal dilakukan langsung di tempat sebagai biaya bulan pertama. Tidak perlu upload bukti pembayaran.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-2">
                                            <div class="d-flex flex-column flex-sm-row gap-2">
                                                <button type="submit" class="btn btn-primary text-white py-3 px-4">
                                                    Ajukan Booking & Bayar Bulan Pertama
                                                </button>

                                                <button type="button" class="btn btn-outline-primary py-3 px-4" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>

                            @else

                                <h5 class="mb-4">
                                    Informasi Status Kamar
                                </h5>

                                <div class="alert alert-light border rounded-0 mb-4">
                                    <strong class="d-block mb-2">
                                        Kamar Belum Bisa Disewa
                                    </strong>

                                    <p class="text-dark mb-0">
                                        Kamar ini belum bisa diajukan sewa karena statusnya saat ini adalah
                                        <strong>
                                            @if($room->status === 'occupied')
                                                Terisi
                                            @elseif($room->status === 'maintenance')
                                                Sedang Perbaikan
                                            @else
                                                {{ $room->status }}
                                            @endif
                                        </strong>.
                                    </p>
                                </div>

                                <div class="border p-4 mb-4">
                                    <div class="mb-3">
                                        <span class="d-block text-muted">
                                            Status
                                        </span>

                                        @if($room->status === 'occupied')
                                            <strong class="text-warning">
                                                Kamar sedang ditempati penghuni lain.
                                            </strong>
                                        @elseif($room->status === 'maintenance')
                                            <strong class="text-danger">
                                                Kamar sedang dalam proses perbaikan.
                                            </strong>
                                        @else
                                            <strong>
                                                {{ $room->status }}
                                            </strong>
                                        @endif
                                    </div>

                                    <div>
                                        <span class="d-block text-muted">
                                            Keterangan
                                        </span>

                                        <p class="text-dark mb-0">
                                            Silakan pilih kamar lain yang statusnya tersedia untuk melakukan checkout.
                                        </p>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-outline-primary py-3 px-4" data-bs-dismiss="modal">
                                    Tutup
                                </button>

                            @endif

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const rupiah = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                });

                document.querySelectorAll('.booking-checkout-form').forEach(function (form) {
                    const roomPrice = Number(form.dataset.roomPrice || 0);
                    const durationInput = form.querySelector('.duration-input');
                    const paymentMethodSelect = form.querySelector('.payment-method-select');

                    const contractDurationText = form.querySelector('.contract-duration-text');
                    const contractTotalText = form.querySelector('.contract-total-text');
                    const initialPaymentText = form.querySelector('.initial-payment-text');

                    const bankTransferArea = form.querySelector('.bank-transfer-area');
                    const qrisInfoArea = form.querySelector('.qris-info-area');
                    const qrisUploadArea = form.querySelector('.qris-upload-area');
                    const codInfoArea = form.querySelector('.cod-info-area');

                    const bankSenderName = form.querySelector('.bank-sender-name');
                    const bankSenderBank = form.querySelector('.bank-sender-bank');
                    const bankPaymentProof = form.querySelector('.bank-payment-proof');

                    const qrisSenderName = form.querySelector('.qris-sender-name');
                    const qrisPaymentProof = form.querySelector('.qris-payment-proof');

                    function updatePaymentSummary() {
                        const duration = Math.max(Number(durationInput.value || 1), 1);

                        contractDurationText.textContent = duration + ' Bulan';
                        contractTotalText.textContent = rupiah.format(roomPrice * duration);
                        initialPaymentText.textContent = rupiah.format(roomPrice);
                    }

                    function disableField(field) {
                        if (!field) {
                            return;
                        }

                        field.disabled = true;
                        field.removeAttribute('required');
                    }

                    function enableRequiredField(field) {
                        if (!field) {
                            return;
                        }

                        field.disabled = false;
                        field.setAttribute('required', 'required');
                    }

                    function resetPaymentFields() {
                        bankTransferArea.classList.add('d-none');
                        qrisInfoArea.classList.add('d-none');
                        qrisUploadArea.classList.add('d-none');
                        codInfoArea.classList.add('d-none');

                        disableField(bankSenderName);
                        disableField(bankSenderBank);
                        disableField(bankPaymentProof);
                        disableField(qrisSenderName);
                        disableField(qrisPaymentProof);
                    }

                    function updatePaymentMethod() {
                        const method = paymentMethodSelect.value;

                        resetPaymentFields();

                        if (method === 'bank_transfer') {
                            bankTransferArea.classList.remove('d-none');

                            enableRequiredField(bankSenderName);
                            enableRequiredField(bankSenderBank);
                            enableRequiredField(bankPaymentProof);
                        }

                        if (method === 'qris') {
                            qrisInfoArea.classList.remove('d-none');
                            qrisUploadArea.classList.remove('d-none');

                            enableRequiredField(qrisSenderName);
                            enableRequiredField(qrisPaymentProof);
                        }

                        if (method === 'cod') {
                            codInfoArea.classList.remove('d-none');
                        }
                    }

                    durationInput.addEventListener('input', updatePaymentSummary);
                    paymentMethodSelect.addEventListener('change', updatePaymentMethod);

                    updatePaymentSummary();
                    updatePaymentMethod();
                });

                document.querySelectorAll('.payment-proof-preview-input').forEach(function (input) {
                    input.addEventListener('change', function () {
                        const file = this.files[0];
                        const wrapper = document.getElementById(this.dataset.previewWrapper);
                        const image = document.getElementById(this.dataset.previewImage);
                        const name = document.getElementById(this.dataset.previewName);

                        if (!wrapper || !image || !name) {
                            return;
                        }

                        if (!file) {
                            wrapper.classList.add('d-none');
                            image.src = '';
                            name.textContent = '';
                            return;
                        }

                        image.src = URL.createObjectURL(file);
                        name.textContent = file.name;
                        wrapper.classList.remove('d-none');
                    });
                });
            });
        </script>
    @endpush
@endonce