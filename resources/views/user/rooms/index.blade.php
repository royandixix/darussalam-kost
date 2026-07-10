@extends('user.layouts.app')

@section('title', 'Cari Kamar')

@section('hide_page_header', true)

@section('content')

<div class="section" style="padding-top: 140px;">
    <div class="container">
        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Kamar Tersedia
                </h2>

                <p class="text-dark mb-0">
                    Temukan kamar, cek fasilitas, lalu ajukan sewa secara online.
                </p>
            </div>

            <div class="col-12 col-lg-6 text-lg-end">
                <a href="{{ route('user.bookings.index') }}" class="btn btn-outline-primary py-3 px-4">
                    Lihat Booking Saya
                </a>
            </div>
        </div>

        <div class="row">

            @forelse($rooms as $room)

                <div class="col-12 col-sm-6 col-lg-4 mb-5">
                    <div class="property-item h-100">
                        <a href="#" class="img" data-bs-toggle="modal" data-bs-target="#roomModal{{ $room->id }}">
                            <img 
                                src="{{ $room->photo ? asset('storage/' . $room->photo) : asset('property-1.0.0/images/img_1.jpg') }}" 
                                alt="Kamar {{ $room->room_number }}" 
                                class="img-fluid"
                            >
                        </a>

                        <div class="property-content">
                            <div class="price mb-2">
                                <span>
                                    Rp {{ number_format($room->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <div>
                                <span class="d-block mb-2 text-black-50">
                                    Kamar {{ $room->room_number }}
                                </span>

                                <span class="city d-block mb-3">
                                    {{ $room->status === 'available' ? 'Tersedia' : ucfirst($room->status) }}
                                </span>

                                <div class="specs d-flex mb-4">
                                    <span class="d-block d-flex align-items-center me-3">
                                        <span class="icon-person me-2"></span>
                                        <span class="caption">
                                            {{ $room->capacity ?? '-' }} orang
                                        </span>
                                    </span>

                                    <span class="d-block d-flex align-items-center">
                                        <span class="icon-home2 me-2"></span>
                                        <span class="caption">
                                            {{ $room->size ?? '-' }} m²
                                        </span>
                                    </span>
                                </div>

                                <button 
                                    type="button"
                                    class="btn btn-primary py-2 px-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#roomModal{{ $room->id }}"
                                >
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                @include('user.rooms.components.modal', ['room' => $room])

            @empty

                <div class="col-12">
                    <div class="box-feature text-center">
                        <span class="flaticon-house"></span>

                        <h3 class="mb-3">
                            Belum Ada Kamar Tersedia
                        </h3>

                        <p class="text-dark mb-0">
                            Saat ini belum ada kamar yang tersedia untuk disewa.
                        </p>
                    </div>
                </div>

            @endforelse

        </div>
    </div>
</div>

@endsection