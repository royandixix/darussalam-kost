<div class="bg-white border-bottom py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">

        <div>
            <h4 class="mb-0 fw-bold">
                {{ trim($__env->yieldContent('page_title','Selamat Datang')) }}
            </h4>

            <small class="text-muted">
                {{ trim($__env->yieldContent('page_subtitle','Dashboard Sistem Kost Darussalam')) }}
            </small>
        </div>

        <div class="text-end">
            <div class="fw-semibold">
                {{ auth()->user()->name ?? 'User' }}
            </div>

            <small class="text-muted">
                {{ ucfirst(auth()->user()->role ?? '-') }}
            </small>
        </div>

    </div>
</div>