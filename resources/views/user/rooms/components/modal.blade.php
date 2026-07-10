<div class="modal fade" id="roomModal{{ $room->id }}" tabindex="-1" aria-labelledby="roomModalLabel{{ $room->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-0">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="roomModalLabel{{ $room->id }}">
                        Kamar {{ $room->room_number }}
                    </h5>
                    <small class="text-muted">
                        Detail kamar dan checkout pemesanan
                    </small>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <form 
                    id="checkoutForm{{ $room->id }}"
                    action="{{ route('user.bookings.store') }}" 
                    method="POST" 
                    enctype="multipart/form-data"
                >
                    @csrf

                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                    <div class="row g-3">

                        <div class="col-md-5">
                            <div class="border rounded-0 p-3">
                                @if($room->photo)
                                    <img 
                                        src="{{ Storage::url($room->photo) }}" 
                                        alt="Kamar {{ $room->room_number }}"
                                        class="img-fluid w-100 rounded-0"
                                    >
                                @else
                                    <img 
                                        src="{{ asset('assets/img/default-room.jpg') }}" 
                                        alt="Default Room"
                                        class="img-fluid w-100 rounded-0"
                                    >
                                @endif

                                <div class="mt-3">
                                    <h5 class="fw-bold mb-1">
                                        Rp {{ number_format($room->price, 0, ',', '.') }}
                                    </h5>

                                    <small class="text-muted">
                                        Harga sewa per bulan
                                    </small>

                                    <hr>

                                    <p class="mb-1">
                                        <span class="text-muted">Kapasitas:</span>
                                        <strong>{{ $room->capacity ?? '-' }} orang</strong>
                                    </p>

                                    <p class="mb-1">
                                        <span class="text-muted">Ukuran:</span>
                                        <strong>{{ $room->size ?? '-' }} m²</strong>
                                    </p>

                                    <p class="mb-1">
                                        <span class="text-muted">Status:</span>

                                        @if($room->status === 'available')
                                            <span class="badge bg-success rounded-0">Tersedia</span>
                                        @elseif($room->status === 'occupied')
                                            <span class="badge bg-danger rounded-0">Terisi</span>
                                        @elseif($room->status === 'maintenance')
                                            <span class="badge bg-warning text-dark rounded-0">Perbaikan</span>
                                        @else
                                            <span class="badge bg-secondary rounded-0">{{ $room->status }}</span>
                                        @endif
                                    </p>

                                    <p class="mb-0">
                                        <span class="text-muted">Fasilitas:</span>
                                        <br>
                                        {{ $room->facilities ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="border rounded-0 p-3">

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Masuk</label>
                                    <input 
                                        type="date" 
                                        name="check_in_date" 
                                        class="form-control rounded-0" 
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Lama Sewa Bulan</label>
                                    <input 
                                        type="number" 
                                        name="duration_month" 
                                        id="duration_month_{{ $room->id }}"
                                        class="form-control rounded-0" 
                                        value="1" 
                                        min="1"
                                        data-price="{{ $room->price }}"
                                        required
                                    >
                                    <small class="text-muted">
                                        Contoh: isi 1 untuk sewa 1 bulan, isi 2 untuk sewa 2 bulan.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Estimasi Total</label>
                                    <div class="border rounded-0 p-3">
                                        <strong id="total_price_{{ $room->id }}">
                                            Rp {{ number_format($room->price, 0, ',', '.') }}
                                        </strong>
                                    </div>
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label class="form-label">Metode Pembayaran</label>

                                    <div class="form-check border rounded-0 p-3 mb-2">
                                        <input 
                                            class="form-check-input payment-method ms-0 me-2 rounded-0" 
                                            type="radio" 
                                            name="payment_method" 
                                            id="bank_transfer_{{ $room->id }}" 
                                            value="bank_transfer"
                                            data-room-id="{{ $room->id }}"
                                            required
                                        >
                                        <label class="form-check-label" for="bank_transfer_{{ $room->id }}">
                                            <strong>Transfer Bank</strong>
                                            <br>
                                            <small class="text-muted">
                                                BRI: 1234567890 a.n Darussalam Kost. Wajib upload bukti.
                                            </small>
                                        </label>
                                    </div>

                                    <div class="form-check border rounded-0 p-3 mb-2">
                                        <input 
                                            class="form-check-input payment-method ms-0 me-2 rounded-0" 
                                            type="radio" 
                                            name="payment_method" 
                                            id="qris_{{ $room->id }}" 
                                            value="qris"
                                            data-room-id="{{ $room->id }}"
                                            required
                                        >
                                        <label class="form-check-label" for="qris_{{ $room->id }}">
                                            <strong>QRIS</strong>
                                            <br>
                                            <small class="text-muted">
                                                Scan QRIS lalu upload bukti pembayaran.
                                            </small>
                                        </label>
                                    </div>

                                    <div class="form-check border rounded-0 p-3">
                                        <input 
                                            class="form-check-input payment-method ms-0 me-2 rounded-0" 
                                            type="radio" 
                                            name="payment_method" 
                                            id="cod_{{ $room->id }}" 
                                            value="cod"
                                            data-room-id="{{ $room->id }}"
                                            required
                                        >
                                        <label class="form-check-label" for="cod_{{ $room->id }}">
                                            <strong>COD / Bayar di Tempat</strong>
                                            <br>
                                            <small class="text-muted">
                                                Tidak perlu upload bukti pembayaran.
                                            </small>
                                        </label>
                                    </div>
                                </div>

                                <div id="payment_proof_area_{{ $room->id }}" class="border rounded-0 p-3 mb-3 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Pengirim</label>
                                        <input 
                                            type="text" 
                                            name="sender_name" 
                                            id="sender_name_{{ $room->id }}"
                                            class="form-control rounded-0"
                                            placeholder="Contoh: Siti Nurhalizah"
                                        >
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Bank / Aplikasi Pengirim</label>
                                        <input 
                                            type="text" 
                                            name="sender_bank" 
                                            id="sender_bank_{{ $room->id }}"
                                            class="form-control rounded-0"
                                            placeholder="Contoh: BRI, BCA, DANA, GoPay"
                                        >
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label">Upload Bukti Pembayaran</label>
                                        <input 
                                            type="file" 
                                            name="payment_proof" 
                                            id="payment_proof_{{ $room->id }}"
                                            class="form-control rounded-0"
                                            accept="image/*"
                                        >
                                        <small class="text-muted">
                                            Wajib untuk Transfer Bank dan QRIS. Maksimal 2MB.
                                        </small>
                                    </div>
                                </div>

                                <div id="cod_info_{{ $room->id }}" class="border rounded-0 p-3 mb-3 d-none">
                                    <strong>COD dipilih.</strong>
                                    <br>
                                    <small class="text-muted">
                                        Bukti pembayaran tidak wajib diupload.
                                    </small>
                                </div>

                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">
                    Batal
                </button>

                @if($room->status === 'available')
                    <button 
                        type="submit" 
                        form="checkoutForm{{ $room->id }}"
                        class="btn btn-primary rounded-0"
                    >
                        Checkout
                    </button>
                @else
                    <button type="button" class="btn btn-secondary rounded-0" disabled>
                        Tidak Tersedia
                    </button>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomId = '{{ $room->id }}';
        const durationInput = document.getElementById('duration_month_' + roomId);
        const totalPriceText = document.getElementById('total_price_' + roomId);

        const proofArea = document.getElementById('payment_proof_area_' + roomId);
        const codInfo = document.getElementById('cod_info_' + roomId);
        const senderName = document.getElementById('sender_name_' + roomId);
        const paymentProof = document.getElementById('payment_proof_' + roomId);

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        function updateTotal() {
            const price = Number(durationInput.getAttribute('data-price'));
            const duration = Number(durationInput.value || 1);

            totalPriceText.innerText = formatRupiah(price * duration);
        }

        function updatePaymentArea(method) {
            if (method === 'bank_transfer' || method === 'qris') {
                proofArea.classList.remove('d-none');
                codInfo.classList.add('d-none');

                senderName.setAttribute('required', 'required');
                paymentProof.setAttribute('required', 'required');
            }

            if (method === 'cod') {
                proofArea.classList.add('d-none');
                codInfo.classList.remove('d-none');

                senderName.removeAttribute('required');
                paymentProof.removeAttribute('required');
            }
        }

        if (durationInput) {
            durationInput.addEventListener('input', updateTotal);
        }

        document.querySelectorAll('.payment-method[data-room-id="' + roomId + '"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                updatePaymentArea(this.value);
            });
        });

        updateTotal();
    });
</script>