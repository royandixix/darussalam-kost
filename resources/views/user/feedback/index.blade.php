@extends('user.layouts.app')

@section('title', 'Feedback')

@section('page_header')
    Feedback Saya
@endsection

@section('page_subtitle')
    Berikan penilaian dan masukan untuk Darussalam Kost
@endsection

@section('content')

<div class="mb-4 text-end">
    <a href="{{ route('user.feedback.create') }}" class="btn btn-primary">
        + Tulis Feedback
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="text-center py-5">

            <h5>Belum Ada Feedback</h5>

            <p class="text-muted">
                Anda belum pernah memberikan feedback.
            </p>

            <a href="{{ route('user.feedback.create') }}"
               class="btn btn-primary mt-3">
                Beri Feedback Sekarang
            </a>

        </div>

    </div>
</div>

@endsection