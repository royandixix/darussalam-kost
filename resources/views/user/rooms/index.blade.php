@extends('user.layouts.app')

@section('title','Daftar Kamar')

@section('page_header','Daftar Kamar Tersedia')

@section('page_subtitle','Pilih kamar sesuai kebutuhan kamu')

@section('content')

<div class="row g-4">

    @foreach($rooms as $room)

        <div class="col-md-4">

            <div class="bg-white">

                <img src="{{ $room->photo ? Storage::url($room->photo) : asset('assets/img/default-room.jpg') }}"
                     class="w-100"
                     style="height:220px;object-fit:cover;border-radius:0;">

                <div class="pt-3">

                    <div class="d-flex justify-content-between align-items-center mb-1">

                        <h6 class="fw-bold mb-0">
                            Kamar {{ $room->room_number }}
                        </h6>

                        <span class="text-muted small">
                            {{ ucfirst($room->status) }}
                        </span>

                    </div>

                    <div class="mb-2 text-dark fw-semibold">
                        Rp {{ number_format($room->price) }}
                    </div>

                    <button class="btn btn-primary w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#roomModal{{ $room->id }}">
                        Lihat Detail
                    </button>

                </div>

            </div>

        </div>

        @include('user.rooms.components.modal', ['room' => $room])

    @endforeach

</div>

@endsection