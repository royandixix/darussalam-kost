<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-0">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="profileModalLabel">
                        Profil Penghuni
                    </h5>

                    <small class="text-muted">
                        Kelola informasi akun, kontak, dan data pribadi kamu.
                    </small>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-12 col-lg-4 mb-4 mb-lg-0">
                        <div class="border p-4 h-100 text-center rounded-0">

                            @if(auth()->user()->photo)
                                <img 
                                    src="{{ asset('storage/' . auth()->user()->photo) }}" 
                                    alt="{{ auth()->user()->name }}"
                                    class="img-fluid mb-4"
                                >
                            @else
                                <div class="mb-4">
                                    <span class="flaticon-house"></span>
                                </div>
                            @endif

                            <h5 class="mb-1">
                                {{ auth()->user()->name }}
                            </h5>

                            <p class="text-muted mb-3">
                                {{ auth()->user()->email }}
                            </p>

                            <span class="badge bg-primary rounded-0 mb-4">
                                {{ auth()->user()->role_label ?? 'Penghuni' }}
                            </span>

                            <div class="text-start mt-4">
                                <div class="mb-3">
                                    <span class="d-block text-muted">
                                        Status Akun
                                    </span>

                                    <strong>
                                        Aktif
                                    </strong>
                                </div>

                                <div class="mb-3">
                                    <span class="d-block text-muted">
                                        Nomor Telepon
                                    </span>

                                    <strong>
                                        {{ auth()->user()->phone ?? '-' }}
                                    </strong>
                                </div>

                                <div>
                                    <span class="d-block text-muted">
                                        Alamat
                                    </span>

                                    <strong>
                                        {{ auth()->user()->address ?? '-' }}
                                    </strong>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-lg-8">
                        <div class="border p-4 h-100 rounded-0">

                            <h5 class="mb-4">
                                Informasi Akun
                            </h5>

                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">
                                        Nama Lengkap
                                    </label>

                                    <input 
                                        type="text" 
                                        name="name" 
                                        class="form-control rounded-0" 
                                        value="{{ old('name', auth()->user()->name) }}"
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Alamat Email
                                    </label>

                                    <input 
                                        type="email" 
                                        class="form-control rounded-0" 
                                        value="{{ auth()->user()->email }}"
                                        readonly
                                    >

                                    <small class="text-muted">
                                        Email digunakan untuk login dan tidak dapat diubah dari halaman ini.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Nomor Telepon
                                    </label>

                                    <input 
                                        type="text" 
                                        name="phone" 
                                        class="form-control rounded-0" 
                                        value="{{ old('phone', auth()->user()->phone) }}"
                                        placeholder="Contoh: 081234567890"
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Alamat
                                    </label>

                                    <textarea 
                                        name="address" 
                                        class="form-control rounded-0" 
                                        rows="3"
                                        placeholder="Masukkan alamat lengkap"
                                    >{{ old('address', auth()->user()->address) }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        Foto Profil
                                    </label>

                                    <input 
                                        type="file" 
                                        name="photo" 
                                        class="form-control rounded-0" 
                                        accept="image/*"
                                    >

                                    <small class="text-muted">
                                        Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                                    </small>
                                </div>

                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <button type="submit" class="btn btn-primary text-white rounded-0">
                                        Simpan Perubahan
                                    </button>

                                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">
                                        Tutup
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>