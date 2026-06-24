<div class="modal fade" id="roomModal{{ $room->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0" style="border-radius:0;overflow:hidden;">

            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">
                    Kamar {{ $room->room_number }}
                </h5>

                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">

                <div class="row g-0">

                    <div class="col-md-5">
                        <img src="{{ $room->photo ? Storage::url($room->photo) : asset('assets/img/default-room.jpg') }}"
                             class="w-100"
                             style="height:100%;object-fit:cover;border-radius:0;">
                    </div>

                    <div class="col-md-7 p-4">

                        <h4 class="fw-bold mb-3">
                            Rp {{ number_format($room->price) }}
                        </h4>

                        <div class="mb-2">
                            <small class="text-muted">Kapasitas</small>
                            <div class="fw-semibold">{{ $room->capacity }} orang</div>
                        </div>

                        <div class="mb-2">
                            <small class="text-muted">Ukuran</small>
                            <div class="fw-semibold">{{ $room->size }} m²</div>
                        </div>

                        <div class="mb-2">
                            <small class="text-muted">Fasilitas</small>
                            <div class="fw-semibold">{{ $room->facilities }}</div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">Status</small>
                            <div class="fw-semibold">{{ $room->status }}</div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <div class="fw-bold mb-2">Metode Pembayaran</div>

                            <div class="border p-2 mb-2">
                                <div class="fw-semibold">QRIS</div>
                                <small class="text-muted">Scan untuk pembayaran instan</small>
                            </div>

                            <div class="border p-2">
                                <div class="fw-semibold">Transfer Bank</div>
                                <small class="text-muted">
                                    BRI: 1234567890 a.n Darussalam Kost
                                </small>
                            </div>
                        </div>

                        <div class="d-grid gap-2">

                            <button class="btn btn-primary">
                                Ajukan Booking
                            </button>

                            <button class="btn btn-outline-primary">
                                Bayar Sekarang
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>