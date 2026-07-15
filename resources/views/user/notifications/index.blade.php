@extends('user.layouts.app')

@section('title', 'Notifikasi')
@section('hide_page_header', true)

@section('content')
<div class="section" style="padding-top: 140px;">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-12 col-md-8 mb-3 mb-md-0">
                <h2 class="font-weight-bold text-primary heading mb-2">Notifikasi</h2>
                <p class="text-dark mb-0">Informasi terbaru mengenai booking, pembayaran, dan perbaikan kamar.</p>
            </div>

            <div class="col-12 col-md-4 text-md-end">
                <form action="{{ route('user.notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary py-2 px-3">
                        Tandai Semua Dibaca
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @forelse($notifications as $notification)
                    <div class="box-feature mb-3 {{ is_null($notification->read_at) ? 'border border-primary' : '' }}">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <h3 class="mb-2">{{ data_get($notification->data, 'title', 'Notifikasi') }}</h3>
                                <p class="text-dark mb-2">{{ data_get($notification->data, 'body', '-') }}</p>
                                <small class="text-black-50">{{ $notification->created_at->format('d M Y H:i') }}</small>
                            </div>

                            @if(is_null($notification->read_at))
                                <span class="badge bg-primary rounded-0">Baru</span>
                            @endif
                        </div>

                        <form action="{{ route('user.notifications.read', $notification) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-primary py-2 px-3">
                                Buka
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="box-feature text-center">
                        <h3 class="mb-3">Belum Ada Notifikasi</h3>
                        <p class="text-dark mb-0">Notifikasi baru akan muncul di halaman ini.</p>
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
