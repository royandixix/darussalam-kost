@extends('user.layouts.app')

@section('title', 'Cari Kamar')

@section('page_header', 'Cari Kamar Kost')

@section('page_subtitle', 'Pilih kamar yang sesuai dengan kebutuhan kamu')

@section('content')

<div class="section">
    <div class="container">
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="font-weight-bold text-primary heading">
                    Kamar Tersedia
                </h2>
            </div>

            <div class="col-lg-6 text-lg-end">
                <p class="mb-0 text-black-50">
                    Temukan kamar, cek fasilitas, lalu ajukan sewa secara online.
                </p>
            </div>
        </div>

        <div class="row">

            @forelse($rooms as $room)

                <div class="col-sm-6 col-md-6 col-lg-4 mb-5">
                    <div class="property-item">
                        <a href="#" class="img" data-bs-toggle="modal" data-bs-target="#roomModal{{ $room->id }}">
                            <img 
                                src="{{ $room->photo ? Storage::url($room->photo) : asset('assets/img/default-room.jpg') }}" 
                                alt="Kamar {{ $room->room_number }}" 
                                class="img-fluid"
                            >
                        </a>

                        <div class="property-content">
                            <div class="price mb-2">
                                <span>Rp {{ number_format($room->price, 0, ',', '.') }}</span>
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
                                        <span class="caption">{{ $room->capacity ?? '-' }} orang</span>
                                    </span>

                                    <span class="d-block d-flex align-items-center">
                                        <span class="icon-home2 me-2"></span>
                                        <span class="caption">{{ $room->size ?? '-' }} m²</span>
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
                    <div class="alert alert-warning">
                        Belum ada kamar yang tersedia saat ini.
                    </div>
                </div>

            @endforelse

        </div>
    </div>
</div>

@endsection