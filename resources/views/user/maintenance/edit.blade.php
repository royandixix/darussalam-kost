@extends('user.layouts.app')

@section('title', 'Edit Laporan Perbaikan')

@section('hide_page_header', true)

@section('content')

<div class="section" style="padding-top: 140px;">
    <div class="container">

        <div class="row mb-5 align-items-center">
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <h2 class="font-weight-bold text-primary heading">
                    Edit Laporan Perbaikan
                </h2>

                <p class="text-dark mb-0">
                    Perbarui laporan kerusakan sebelum laporan diproses oleh admin atau teknisi.
                </p>
            </div>

            <div class="col-12 col-lg-5 text-lg-end">
                <a href="{{ route('user.maintenance.index') }}" class="btn btn-outline-primary py-3 px-4">
                    Kembali ke Laporan
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                <div class="box-feature h-100">
                    <span class="flaticon-house-3"></span>

                    <h3 class="mb-4">
                        Informasi Edit
                    </h3>

                    <div class="mb-4">
                        <strong>
                            Laporan Masih Menunggu
                        </strong>

                        <p class="text-dark mb-0">
                            Laporan ini masih bisa diedit karena belum diproses oleh admin atau teknisi.
                        </p>
                    </div>

                    <div class="mb-4">
                        <strong>
                            Foto Kerusakan
                        </strong>

                        <p class="text-dark mb-0">
                            Jika kamu upload foto baru, foto lama akan diganti otomatis.
                        </p>
                    </div>

                    <div>
                        <strong>
                            Setelah Diproses
                        </strong>

                        <p class="text-dark mb-0">
                            Jika laporan sudah ditugaskan, sedang dikerjakan, atau selesai, laporan tidak bisa diedit lagi.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="box-feature h-100">
                    <span class="flaticon-building"></span>

                    <h3 class="mb-4">
                        Form Edit Laporan
                    </h3>

                    <form action="{{ route('user.maintenance.update', $maintenanceReport) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Kamar
                            </label>

                            <select
                                name="room_id"
                                class="form-control rounded-0 @error('room_id') is-invalid @enderror"
                                required
                            >
                                <option value="">Pilih Kamar</option>

                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id', $maintenanceReport->room_id) == $room->id ? 'selected' : '' }}>
                                        Kamar {{ $room->room_number }}
                                    </option>
                                @endforeach
                            </select>

                            @error('room_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Judul Kerusakan
                            </label>

                            <input
                                type="text"
                                name="title"
                                value="{{ old('title', $maintenanceReport->title) }}"
                                class="form-control rounded-0 @error('title') is-invalid @enderror"
                                placeholder="Contoh: Banyak sarang laba-laba dan kotoran di kamar"
                                required
                            >

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Deskripsi Kerusakan
                            </label>

                            <textarea
                                name="description"
                                rows="5"
                                class="form-control rounded-0 @error('description') is-invalid @enderror"
                                placeholder="Jelaskan kerusakan secara detail"
                                required
                            >{{ old('description', $maintenanceReport->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if($maintenanceReport->photo)
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Foto Saat Ini
                                </label>

                                <div class="border p-3">
                                    <img
                                        src="{{ asset('storage/' . $maintenanceReport->photo) }}"
                                        alt="Foto Kerusakan"
                                        class="img-fluid"
                                        style="max-height: 320px;"
                                    >
                                </div>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Ganti Foto Kerusakan
                            </label>

                            <input
                                type="file"
                                name="photo"
                                class="form-control rounded-0 @error('photo') is-invalid @enderror"
                                accept="image/*"
                                id="maintenancePhotoInput"
                            >

                            <small class="text-black-50">
                                Kosongkan jika tidak ingin mengganti foto. Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                            </small>

                            @error('photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4 d-none" id="maintenancePhotoPreviewWrapper">
                            <label class="form-label fw-semibold">
                                Preview Foto Baru
                            </label>

                            <div class="border p-3">
                                <img
                                    id="maintenancePhotoPreview"
                                    src=""
                                    alt="Preview Foto Baru"
                                    class="img-fluid mb-3"
                                    style="max-height: 320px;"
                                >

                                <div class="text-black-50" id="maintenancePhotoName"></div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-primary text-white py-3 px-4">
                                Simpan Perubahan
                            </button>

                            <a href="{{ route('user.maintenance.index') }}" class="btn btn-outline-primary py-3 px-4">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('maintenancePhotoInput');
        const wrapper = document.getElementById('maintenancePhotoPreviewWrapper');
        const image = document.getElementById('maintenancePhotoPreview');
        const name = document.getElementById('maintenancePhotoName');

        if (!input) {
            return;
        }

        input.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) {
                wrapper.classList.add('d-none');
                image.src = '';
                name.innerText = '';
                return;
            }

            image.src = URL.createObjectURL(file);
            name.innerText = file.name;
            wrapper.classList.remove('d-none');
        });
    });
</script>
@endpush