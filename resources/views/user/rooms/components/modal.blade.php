<div class="modal fade" id="roomModal{{ $room->id }}" tabindex="-1" aria-labelledby="roomModalLabel{{ $room->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content rounded-0">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="roomModalLabel{{ $room->id }}">
                        Detail Kamar {{ $room->room_number }}
                    </h5>

                    <small class="text-muted">
                        Cek detail kamar dan ajukan sewa secara online.
                    </small>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                        <div class="border h-100">
                            <img 
                                src="{{ $room->photo ? asset('storage/' . $room->photo) : asset('property-1.0.0/images/img_1.jpg') }}" 
                                alt="Kamar {{ $room->room_number }}" 
                                class="img-fluid w-100"
                            >

                            <div class="p-4">
                                <h4 class="text-primary mb-3">
                                    Kamar {{ $room->room_number }}
                                </h4>

                                <div class="mb-3">
                                    <span class="d-block text-black-50">
                                        Harga Per Bulan
                                    </span>

                                    <h3 class="text-primary mb-0">
                                        Rp {{ number_format($room->price, 0, ',', '.') }}
                                    </h3>
                                </div>

                                <div class="mb-3">
                                    <span class="d-block text-black-50">
                                        Kapasitas
                                    </span>

                                    <strong>
                                        {{ $room->capacity ?? '-' }} orang
                                    </strong>
                                </div>

                                <div class="mb-3">
                                    <span class="d-block text-black-50">
                                        Ukuran
                                    </span>

                                    <strong>
                                        {{ $room->size ?? '-' }} m²
                                    </strong>
                                </div>

                                <div class="mb-3">
                                    <span class="d-block text-black-50">
                                        Status
                                    </span>

                                    @if($room->status === 'available')
                                        <span class="badge bg-success rounded-0">
                                            Tersedia
                                        </span>
                                    @elseif($room->status === 'occupied')
                                        <span class="badge bg-danger rounded-0">
                                            Terisi
                                        </span>
                                    @elseif($room->status === 'maintenance')
                                        <span class="badge bg-warning text-dark rounded-0">
                                            Perbaikan
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-0">
                                            {{ $room->status }}
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    <span class="d-block text-black-50">
                                        Fasilitas
                                    </span>

                                    <p class="text-dark mb-0">
                                        {{ $room->facilities ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7">
                        <div class="border p-4 h-100">

                            <h4 class="text-primary mb-3">
                                Form Checkout
                            </h4>

                            <p class="text-dark mb-4">
                                Pilih tanggal masuk, lama sewa, dan metode pembayaran.
                            </p>

                            @if($room->status === 'available')

                                <form id="checkoutForm{{ $room->id }}" action="{{ route('user.bookings.store') }}" method="POST" enctype="multipart/form-data">
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
                                                Lama Sewa Bulan
                                            </label>

                                            <input 
                                                type="number" 
                                                name="duration_month" 
                                                class="form-control rounded-0 duration-input" 
                                                min="1"
                                                value="1"
                                                data-price="{{ $room->price }}"
                                                data-target="totalPrice{{ $room->id }}"
                                                required
                                            >
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="alert alert-info rounded-0 mb-0">
                                                Total pembayaran:
                                                <strong id="totalPrice{{ $room->id }}">
                                                    Rp {{ number_format($room->price, 0, ',', '.') }}
                                                </strong>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <label class="form-label fw-semibold">
                                                Metode Pembayaran
                                            </label>

                                            <select 
                                                name="payment_method" 
                                                class="form-control rounded-0 payment-method-select" 
                                                data-room-id="{{ $room->id }}"
                                                required
                                            >
                                                <option value="">Pilih Metode Pembayaran</option>
                                                <option value="bank_transfer">Transfer Bank</option>
                                                <option value="qris">QRIS</option>
                                                <option value="cod">COD / Bayar di Tempat</option>
                                            </select>
                                        </div>

                                        <div class="col-12 mb-4 d-none" id="bankInfo{{ $room->id }}">
                                            <div class="alert alert-light border rounded-0 mb-0">
                                                <h6 class="text-primary mb-3">
                                                    Informasi Transfer Bank
                                                </h6>

                                                <div class="mb-2">
                                                    Bank:
                                                    <strong>BCA</strong>
                                                </div>

                                                <div class="mb-2">
                                                    Nomor Rekening:
                                                    <strong>827351492608</strong>
                                                </div>

                                                <div>
                                                    Atas Nama:
                                                    <strong>Kosan Darussalam</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4 d-none" id="qrisInfo{{ $room->id }}">
                                            <div class="alert alert-light border rounded-0 mb-0">
                                                <h6 class="text-primary mb-3">
                                                    Scan QRIS
                                                </h6>

                                                <p class="text-dark mb-3">
                                                    Silakan scan QRIS berikut, lalu upload bukti pembayaran.
                                                </p>

                                                @if(file_exists(public_path('images/qris.png')))
                                                    <img src="{{ asset('images/qris.png') }}" alt="QRIS" class="img-fluid" style="max-width: 260px;">
                                                @else
                                                    <div class="alert alert-warning rounded-0 mb-0">
                                                        QRIS belum tersedia. Simpan gambar QRIS di public/images/qris.png
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4 d-none" id="codInfo{{ $room->id }}">
                                            <div class="alert alert-info rounded-0 mb-0">
                                                Kamu memilih COD / Bayar di Tempat. Bukti pembayaran tidak wajib diupload.
                                            </div>
                                        </div>

                                        <div class="col-12 d-none" id="bankTransferArea{{ $room->id }}">
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
                                                    placeholder="Contoh: BCA - 827351492608"
                                                >
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-semibold">
                                                    Upload Bukti Pembayaran
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

                                                <small class="text-black-50">
                                                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                                                </small>
                                            </div>

                                            <div class="mb-4 d-none" id="bankPreviewWrapper{{ $room->id }}">
                                                <label class="form-label fw-semibold">
                                                    Preview Bukti Transfer
                                                </label>

                                                <div class="border p-3">
                                                    <img 
                                                        id="bankPreviewImage{{ $room->id }}" 
                                                        src="" 
                                                        alt="Preview Bukti Transfer"
                                                        class="img-fluid mb-3"
                                                        style="max-height: 320px;"
                                                    >

                                                    <div class="text-black-50 mb-3" id="bankPreviewName{{ $room->id }}"></div>

                                                    <button 
                                                        type="button" 
                                                        class="btn btn-outline-danger btn-sm rounded-0 clear-payment-preview"
                                                        data-input-class="bank-payment-proof"
                                                        data-preview-wrapper="bankPreviewWrapper{{ $room->id }}"
                                                        data-preview-image="bankPreviewImage{{ $room->id }}"
                                                        data-preview-name="bankPreviewName{{ $room->id }}"
                                                    >
                                                        Hapus Bukti
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-none" id="qrisUploadArea{{ $room->id }}">
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

                                                <small class="text-black-50">
                                                    Upload screenshot atau foto bukti pembayaran QRIS. Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                                                </small>
                                            </div>

                                            <div class="mb-4 d-none" id="qrisPreviewWrapper{{ $room->id }}">
                                                <label class="form-label fw-semibold">
                                                    Preview Bukti QRIS
                                                </label>

                                                <div class="border p-3">
                                                    <img 
                                                        id="qrisPreviewImage{{ $room->id }}" 
                                                        src="" 
                                                        alt="Preview Bukti QRIS"
                                                        class="img-fluid mb-3"
                                                        style="max-height: 320px;"
                                                    >

                                                    <div class="text-black-50 mb-3" id="qrisPreviewName{{ $room->id }}"></div>

                                                    <button 
                                                        type="button" 
                                                        class="btn btn-outline-danger btn-sm rounded-0 clear-payment-preview"
                                                        data-input-class="qris-payment-proof"
                                                        data-preview-wrapper="qrisPreviewWrapper{{ $room->id }}"
                                                        data-preview-image="qrisPreviewImage{{ $room->id }}"
                                                        data-preview-name="qrisPreviewName{{ $room->id }}"
                                                    >
                                                        Hapus Bukti
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>

                            @else

                                <div class="alert alert-warning rounded-0 mb-0">
                                    Kamar ini belum tersedia untuk disewa.
                                </div>

                            @endif

                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary py-2 px-4" data-bs-dismiss="modal">
                    Tutup
                </button>

                @if($room->status === 'available')
                    <button type="submit" form="checkoutForm{{ $room->id }}" class="btn btn-primary text-white py-2 px-4">
                        Checkout Sekarang
                    </button>
                @endif
            </div>

        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.duration-input').forEach(function (input) {
            input.addEventListener('input', function () {
                const price = parseInt(this.dataset.price);
                const target = document.getElementById(this.dataset.target);
                const duration = parseInt(this.value) || 1;
                const total = price * duration;

                target.innerText = 'Rp ' + total.toLocaleString('id-ID');
            });
        });

        document.querySelectorAll('.payment-method-select').forEach(function (select) {
            select.addEventListener('change', function () {
                const roomId = this.dataset.roomId;
                const method = this.value;

                const bankInfo = document.getElementById('bankInfo' + roomId);
                const qrisInfo = document.getElementById('qrisInfo' + roomId);
                const codInfo = document.getElementById('codInfo' + roomId);
                const bankTransferArea = document.getElementById('bankTransferArea' + roomId);
                const qrisUploadArea = document.getElementById('qrisUploadArea' + roomId);

                const bankSenderName = bankTransferArea.querySelector('.bank-sender-name');
                const bankSenderBank = bankTransferArea.querySelector('.bank-sender-bank');
                const bankPaymentProof = bankTransferArea.querySelector('.bank-payment-proof');
                const qrisPaymentProof = qrisUploadArea.querySelector('.qris-payment-proof');

                bankInfo.classList.add('d-none');
                qrisInfo.classList.add('d-none');
                codInfo.classList.add('d-none');
                bankTransferArea.classList.add('d-none');
                qrisUploadArea.classList.add('d-none');

                bankSenderName.removeAttribute('required');
                bankSenderBank.removeAttribute('required');
                bankPaymentProof.removeAttribute('required');
                qrisPaymentProof.removeAttribute('required');

                bankSenderName.disabled = true;
                bankSenderBank.disabled = true;
                bankPaymentProof.disabled = true;
                qrisPaymentProof.disabled = true;

                if (method === 'bank_transfer') {
                    bankInfo.classList.remove('d-none');
                    bankTransferArea.classList.remove('d-none');

                    bankSenderName.disabled = false;
                    bankSenderBank.disabled = false;
                    bankPaymentProof.disabled = false;

                    bankSenderName.setAttribute('required', 'required');
                    bankSenderBank.setAttribute('required', 'required');
                    bankPaymentProof.setAttribute('required', 'required');
                }

                if (method === 'qris') {
                    qrisInfo.classList.remove('d-none');
                    qrisUploadArea.classList.remove('d-none');

                    qrisPaymentProof.disabled = false;
                    qrisPaymentProof.setAttribute('required', 'required');
                }

                if (method === 'cod') {
                    codInfo.classList.remove('d-none');
                }
            });
        });

        document.querySelectorAll('.payment-method-select').forEach(function (select) {
            select.dispatchEvent(new Event('change'));
        });

        document.addEventListener('change', function (event) {
            const input = event.target.closest('.payment-proof-preview-input');

            if (!input) {
                return;
            }

            const file = input.files[0];
            const wrapper = document.getElementById(input.dataset.previewWrapper);
            const image = document.getElementById(input.dataset.previewImage);
            const name = document.getElementById(input.dataset.previewName);

            if (!file) {
                wrapper.classList.add('d-none');
                image.src = '';
                name.innerText = '';
                return;
            }

            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Tidak Valid',
                    text: 'Bukti pembayaran harus berupa gambar JPG, JPEG, PNG, atau WEBP.',
                    confirmButtonText: 'Oke'
                });

                input.value = '';
                wrapper.classList.add('d-none');
                image.src = '';
                name.innerText = '';
                return;
            }

            image.src = URL.createObjectURL(file);
            name.innerText = file.name;
            wrapper.classList.remove('d-none');
        });

        document.addEventListener('click', function (event) {
            const button = event.target.closest('.clear-payment-preview');

            if (!button) {
                return;
            }

            const wrapper = document.getElementById(button.dataset.previewWrapper);
            const image = document.getElementById(button.dataset.previewImage);
            const name = document.getElementById(button.dataset.previewName);
            const input = wrapper.closest('form').querySelector('.' + button.dataset.inputClass);

            if (input) {
                input.value = '';
            }

            image.src = '';
            name.innerText = '';
            wrapper.classList.add('d-none');
        });
    });
</script>
@endpush
@endonce