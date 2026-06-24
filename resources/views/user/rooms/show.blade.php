@extends('user.layouts.app')

@section('title','Detail Kamar')

@section('content')

<div class="card">
    <div class="card-body">
        <h3>Kamar {{ $room->room_number }}</h3>

        <p><b>Harga:</b> Rp {{ number_format($room->price) }}</p>
        <p><b>Kapasitas:</b> {{ $room->capacity }} orang</p>
        <p><b>Ukuran:</b> {{ $room->size }} m²</p>
        <p><b>Fasilitas:</b> {{ $room->facilities }}</p>
        <p><b>Status:</b> {{ $room->status }}</p>

        <a href="{{ route('user.rooms.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>
</div> 

@endsection