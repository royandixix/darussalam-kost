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
                                                    <strong>BCA / BRI / Mandiri</strong>
                                                </div>

                                                <div class="mb-2">
                                                    Nomor Rekening:
                                                    <strong>1234567890</strong>
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

                                        <div class="col-12 payment-proof-area" id="paymentProofArea{{ $room->id }}">
                                            <div class="mb-4">
                                                <label class="form-label fw-semibold">
                                                    Nama Pengirim
                                                </label>

                                                <input 
                                                    type="text" 
                                                    name="sender_name" 
                                                    class="form-control rounded-0 sender-name-input"
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
                                                    class="form-control rounded-0"
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
                                                    class="form-control rounded-0 payment-proof-input"
                                                    accept="image/*"
                                                >

                                                <small class="text-black-50">
                                                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                                                </small>
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
                const proofArea = document.getElementById('paymentProofArea' + roomId);
                const senderInput = proofArea.querySelector('.sender-name-input');
                const proofInput = proofArea.querySelector('.payment-proof-input');

                bankInfo.classList.add('d-none');
                qrisInfo.classList.add('d-none');
                codInfo.classList.add('d-none');

                senderInput.removeAttribute('required');
                proofInput.removeAttribute('required');

                if (method === 'bank_transfer') {
                    bankInfo.classList.remove('d-none');
                    proofArea.classList.remove('d-none');
                    senderInput.setAttribute('required', 'required');
                    proofInput.setAttribute('required', 'required');
                }

                if (method === 'qris') {
                    qrisInfo.classList.remove('d-none');
                    proofArea.classList.remove('d-none');
                    senderInput.setAttribute('required', 'required');
                    proofInput.setAttribute('required', 'required');
                }

                if (method === 'cod') {
                    codInfo.classList.remove('d-none');
                    proofArea.classList.add('d-none');
                    senderInput.removeAttribute('required');
                    proofInput.removeAttribute('required');
                }

                if (method === '') {
                    proofArea.classList.remove('d-none');
                }
            });
        });
    });
</script>
@endpush