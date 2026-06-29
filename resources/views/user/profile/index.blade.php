@extends('user.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="card-body">
                    <div class="position-relative d-inline-block mb-3">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-primary font-weight-bold shadow-sm mx-auto" style="width: 100px; height: 100px; font-size: 2.5rem; background: linear-gradient(135deg, #e0e7ff 0%, #e0f2fe 100%);">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1 text-dark">{{ auth()->user()->name }}</h5>
                    <p class="text-muted small mb-3">{{ auth()->user()->email }}</p>
                    <span class="badge bg-light text-primary px-3 py-2 rounded-pill font-semibold small">Sesi Aktif</span>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <ul class="nav nav-tabs card-header-tabs border-bottom-0" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold text-dark border-0 pb-3" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-content" type="button" role="tab" aria-controls="info-content" aria-selected="true">
                                Informasi Akun
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body p-4">
                    <div class="tab-content" id="profileTabContent">
                        <div class="tab-pane fade show active" id="info-content" role="tabpanel" aria-labelledby="info-tab">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label small text-muted text-uppercase font-weight-bold tracking-wider">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0 text-muted px-3"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control bg-light border-0 py-2.5 px-3" value="{{ auth()->user()->name }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label small text-muted text-uppercase font-weight-bold tracking-wider">Alamat Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0 text-muted px-3"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control bg-light border-0 py-2.5 px-3" value="{{ auth()->user()->email }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection