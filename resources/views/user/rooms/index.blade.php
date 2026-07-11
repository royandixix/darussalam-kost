@extends('user.layouts.app')

@section('title', 'Cari Kamar')

@section('hide_page_header', true)

@section('content')

<style>
    .rooms-page .room-card {
        height: 100%;
        min-height: 520px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #ffffff;
    }

    .rooms-page .room-image-link {
        display: block;
        width: 100%;
        height: 260px;
        overflow: hidden;
        background: #f3f4f6;
    }

    .rooms-page .room-image {
        width: 100%;
        height: 260px;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .rooms-page .room-content {
        flex: 1;
        min-height: 260px;
        display: flex;
        flex-direction: column;
    }

    .rooms-page .room-price {
        min-height: 38px;
    }

    .rooms-page .room-title {
        min-height: 24px;
    }

    .rooms-page .room-status {
        min-height: 28px;
    }

    .rooms-page .room-specs {
        min-height: 34px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .rooms-page .room-action {
        margin-top: auto;
    }

    @media (max-width: 575px) {
        .rooms-page .room-card {
            min-height: 500px;
        }

        .rooms-page .room-image-link,
        .rooms-page .room-image {
            height: 240px;
        }

        .rooms-page .room-content {
            min-height: 240px;
        }
    }
</style>

<div class="section rooms-page" style="padding-top: 140px;">
    <div class="container">
        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Daftar Kamar
                </h2>

                <p class="text-dark mb-0">
                    Lihat daftar kamar, fasilitas, status ketersediaan, dan ajukan sewa jika kamar masih tersedia.
                </p>
            </div>

            <div class="col-12 col-lg-6 text-lg-end">
                <a href="{{ route('user.bookings.index') }}" class="btn btn-outline-primary py-3 px-4">
                    Lihat Booking Saya
                </a>
            </div>
        </div>

        <div class="row align-items-stretch">

            @forelse($rooms as $room)

                <div class="col-12 col-sm-6 col-lg-4 mb-5 d-flex">
                    <div class="property-item room-card w-100">
                        <a href="#" class="img room-image-link" data-bs-toggle="modal" data-bs-target="#roomModal{{ $room->id }}">
                            <img
                                src="{{ $room->photo ? asset('storage/' . $room->photo) : asset('property-1.0.0/images/img_1.jpg') }}"
                                alt="Kamar {{ $room->room_number }}"
                                class="room-image"
                            >
                        </a>

                        <div class="property-content room-content">
                            <div class="price mb-2 room-price">
                                <span>
                                    Rp {{ number_format($room->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <span class="d-block mb-2 text-black-50 room-title">
                                Kamar {{ $room->room_number }}
                            </span>

                            <span class="city d-block mb-3 room-status">
                                @if($room->status === 'available')
                                    Tersedia
                                @elseif($room->status === 'occupied')
                                    Terisi
                                @elseif($room->status === 'maintenance')
                                    Perbaikan
                                @else
                                    {{ $room->status }}
                                @endif
                            </span>

                            <div class="specs room-specs mb-4">
                                <span class="d-flex align-items-center">
                                    <span class="icon-person me-2"></span>
                                    <span class="caption">
                                        {{ $room->capacity ?? '-' }} orang
                                    </span>
                                </span>

                                <span class="d-flex align-items-center">
                                    <span class="icon-home2 me-2"></span>
                                    <span class="caption">
                                        {{ $room->size ?? '-' }} m²
                                    </span>
                                </span>
                            </div>

                            <div class="room-action">
                                <button
                                    type="button"
                                    class="btn {{ $room->status === 'available' ? 'btn-primary' : 'btn-outline-primary' }} py-2 px-3 w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#roomModal{{ $room->id }}"
                                >
                                    @if($room->status === 'available')
                                        Lihat Detail
                                    @else
                                        Lihat Info
                                    @endif
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
                            Belum Ada Data Kamar
                        </h3>

                        <p class="text-dark mb-0">
                            Saat ini belum ada data kamar yang tersedia.
                        </p>
                    </div>
                </div>

            @endforelse

        </div>
    </div>
</div>

@endsection