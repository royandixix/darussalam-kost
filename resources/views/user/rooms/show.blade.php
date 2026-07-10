@extends('user.layouts.app')

@section('title', 'Detail Kamar')

@section('hide_page_header', true)

@section('content')

<div class="section" style="padding-top: 140px;">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Detail Kamar {{ $room->room_number }}
                </h2>

                <p class="text-dark mb-0">
                    Cek informasi kamar sebelum melakukan checkout.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.rooms.index') }}" class="btn btn-outline-primary py-3 px-4">
                    Kembali ke Cari Kamar
                </a>
            </div>
        </div>

        <div class="box-feature">
            <div class="row align-items-center">

                <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                    <img 
                        src="{{ $room->photo ? asset('storage/' . $room->photo) : asset('property-1.0.0/images/img_1.jpg') }}" 
                        alt="Kamar {{ $room->room_number }}" 
                        class="img-fluid w-100"
                    >
                </div>

                <div class="col-12 col-lg-7">
                    <h3 class="text-primary mb-4">
                        Kamar {{ $room->room_number }}
                    </h3>

                    <div class="mb-3">
                        <span class="d-block text-black-50">
                            Harga
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
                            {{ $room->capacity }} orang
                        </strong>
                    </div>

                    <div class="mb-3">
                        <span class="d-block text-black-50">
                            Ukuran
                        </span>

                        <strong>
                            {{ $room->size }} m²
                        </strong>
                    </div>

                    <div class="mb-3">
                        <span class="d-block text-black-50">
                            Fasilitas
                        </span>

                        <p class="text-dark mb-0">
                            {{ $room->facilities }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <span class="d-block text-black-50">
                            Status
                        </span>

                        <strong>
                            {{ $room->status === 'available' ? 'Tersedia' : ucfirst($room->status) }}
                        </strong>
                    </div>

                    <button 
                        type="button"
                        class="btn btn-primary text-white py-3 px-4"
                        data-bs-toggle="modal"
                        data-bs-target="#roomModal{{ $room->id }}"
                    >
                        Checkout Kamar
                    </button>
                </div>

            </div>
        </div>

        @include('user.rooms.components.modal', ['room' => $room])

    </div>
</div>

@endsection