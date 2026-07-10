@extends('user.layouts.app')

@section('title', 'Feedback Saya')

@section('page_header', 'Feedback Saya')

@section('page_subtitle', 'Daftar penilaian dan masukan yang sudah kamu kirim')

@section('content')

<div class="section">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Riwayat Feedback
                </h2>

                <p class="text-dark mb-0">
                    Lihat feedback, rating, dan masukan yang sudah kamu kirim untuk Darussalam Kost.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.feedback.create') }}" class="btn btn-primary text-white py-3 px-4">
                    Tulis Feedback
                </a>
            </div>
        </div>

        <div class="row mb-5">

            <div class="col-12 col-md-4 mb-4">
                <div class="box-feature h-100">
                    <span class="flaticon-house"></span>

                    <h3 class="mb-3">
                        {{ $totalFeedback ?? 0 }}
                    </h3>

                    <p class="mb-2">
                        Total Feedback
                    </p>

                    <p class="text-dark mb-0">
                        Jumlah feedback yang sudah kamu kirim.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4 mb-4">
                <div class="box-feature h-100">
                    <span class="flaticon-building"></span>

                    <h3 class="mb-3">
                        {{ $averageRating ?? 0 }}
                    </h3>

                    <p class="mb-2">
                        Rata-rata Rating
                    </p>

                    <p class="text-dark mb-0">
                        Nilai rata-rata dari penilaian kamu.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4 mb-4">
                <div class="box-feature h-100">
                    <span class="flaticon-house-1"></span>

                    <h3 class="mb-3">
                        {{ $publishedFeedback ?? 0 }}
                    </h3>

                    <p class="mb-2">
                        Dipublikasikan
                    </p>

                    <p class="text-dark mb-0">
                        Feedback yang dapat ditampilkan oleh admin.
                    </p>
                </div>
            </div>

        </div>

        <div class="row">

            @forelse($feedbacks as $feedback)

                <div class="col-12 col-lg-6 mb-4">
                    <div class="box-feature h-100">

                        <div class="d-flex justify-content-between align-items-start gap-3 mb-4 flex-wrap">
                            <div>
                                <span class="d-block text-black-50 mb-1">
                                    Feedback #{{ $feedback->id }}
                                </span>

                                <h3 class="mb-0">
                                    Kamar {{ $feedback->booking?->room?->room_number ?? '-' }}
                                </h3>
                            </div>

                            <div>
                                @if($feedback->is_published)
                                    <span class="badge bg-success rounded-0">
                                        Dipublikasikan
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-0">
                                        Menunggu Review
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50 mb-2">
                                Rating
                            </span>

                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $feedback->rating)
                                        <span class="icon-star text-warning"></span>
                                    @else
                                        <span class="icon-star text-black-50"></span>
                                    @endif
                                @endfor

                                <strong class="ms-2">
                                    {{ $feedback->rating }}/5
                                </strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Komentar
                            </span>

                            <p class="text-dark mb-0">
                                {{ $feedback->comment }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-black-50">
                                Tanggal Feedback
                            </span>

                            <strong>
                                {{ $feedback->created_at->format('d M Y') }}
                            </strong>
                        </div>

                        <div>
                            <span class="d-block text-black-50 mb-2">
                                Status Booking
                            </span>

                            @if($feedback->booking?->status === 'pending')
                                <span class="badge bg-warning text-dark rounded-0">
                                    Menunggu
                                </span>
                            @elseif($feedback->booking?->status === 'approved')
                                <span class="badge bg-success rounded-0">
                                    Disetujui
                                </span>
                            @elseif($feedback->booking?->status === 'rejected')
                                <span class="badge bg-danger rounded-0">
                                    Ditolak
                                </span>
                            @elseif($feedback->booking?->status === 'completed')
                                <span class="badge bg-primary rounded-0">
                                    Selesai
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-0">
                                    -
                                </span>
                            @endif
                        </div>

                    </div>
                </div>

            @empty

                <div class="col-12">
                    <div class="box-feature text-center">
                        <span class="flaticon-house-1"></span>

                        <h3 class="mb-3">
                            Belum Ada Feedback
                        </h3>

                        <p class="text-dark mb-4">
                            Kamu belum pernah memberikan feedback. Setelah booking disetujui atau selesai, kamu bisa memberikan penilaian dan masukan.
                        </p>

                        <a href="{{ route('user.feedback.create') }}" class="btn btn-primary text-white py-3 px-4">
                            Beri Feedback Sekarang
                        </a>
                    </div>
                </div>

            @endforelse

        </div>

    </div>
</div>

@endsection