@extends('user.layouts.app')

@section('title', 'Ajukan Booking')

@section('page_header', 'Ajukan Booking Kamar')

@section('page_subtitle', 'Isi data pemesanan kamar sebelum melakukan pembayaran.')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($rooms->isEmpty())
            <div class="alert alert-warning mb-0">
                Belum ada kamar tersedia untuk dibooking.
            </div>
        @else
            <form action="{{ route('user.bookings.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Kamar</label>
                    <select name="room_id" class="form-select" required>
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}"
                                {{ old('room_id', $selectedRoomId ?? '') == $room->id ? 'selected' : '' }}>
                                Kamar {{ $room->room_number }} - Rp{{ number_format($room->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Masuk</label>
                    <input 
                        type="date" 
                        name="check_in_date" 
                        class="form-control" 
                        value="{{ old('check_in_date') }}" 
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Durasi Sewa</label>
                    <input 
                        type="number" 
                        name="duration_month" 
                        class="form-control" 
                        value="{{ old('duration_month', 1) }}" 
                        min="1" 
                        required
                    >
                    <small class="text-muted">Isi dalam satuan bulan.</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan Booking
                    </button>

                    <a href="{{ route('user.rooms.index') }}" class="btn btn-light">
                        Kembali
                    </a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection