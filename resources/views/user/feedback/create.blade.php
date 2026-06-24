@extends('user.layouts.app')

@section('title', 'Buat Feedback')

@section('page_header')
    Buat Feedback
@endsection

@section('page_subtitle')
    Berikan penilaian dan masukan untuk Darussalam Kost
@endsection

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <form action="{{ route('user.feedback.store') }}" method="POST">
            @csrf

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Rating
                </label>

                <select
                    name="rating"
                    class="form-control @error('rating') is-invalid @enderror">

                    <option value="">Pilih Rating</option>

                    <option value="5">⭐⭐⭐⭐⭐ Sangat Puas</option>
                    <option value="4">⭐⭐⭐⭐ Puas</option>
                    <option value="3">⭐⭐⭐ Cukup</option>
                    <option value="2">⭐⭐ Kurang</option>
                    <option value="1">⭐ Buruk</option>

                </select>

                @error('rating')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Komentar
                </label>

                <textarea
                    name="comment"
                    rows="5"
                    class="form-control @error('comment') is-invalid @enderror"
                    placeholder="Tuliskan pengalaman Anda selama tinggal di Darussalam Kost...">{{ old('comment') }}</textarea>

                @error('comment')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="d-flex gap-2">

                <button type="submit" class="btn btn-primary">
                    Kirim Feedback
                </button>

                <a href="{{ route('user.feedback.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </div>

        </form>

    </div>
</div>

@endsection