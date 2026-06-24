@extends('user.layouts.app')

@section('title', 'Buat Laporan Perbaikan')

@section('page_header')
    Buat Laporan Perbaikan
@endsection

@section('page_subtitle')
    Laporkan kerusakan fasilitas atau kamar
@endsection

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <form action="{{ route('user.maintenance.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kamar</label>

                <select
                    name="room_id"
                    class="form-control @error('room_id') is-invalid @enderror">

                    <option value="">Pilih Kamar</option>

                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">
                            {{ $room->room_number }}
                        </option>
                    @endforeach

                </select>

                @error('room_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Judul Kerusakan
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="form-control @error('title') is-invalid @enderror">

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="5"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <button class="btn btn-primary">
                Kirim Laporan
            </button>

            <a
                href="{{ route('user.maintenance.index') }}"
                class="btn btn-secondary">

                Kembali
            </a>

        </form>

    </div>
</div>

@endsection