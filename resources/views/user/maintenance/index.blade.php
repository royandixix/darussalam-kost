@if($report->updates->count() > 0)
    <div class="mt-4">
        <span class="d-block text-black-50 mb-2">
            Riwayat Catatan Teknisi
        </span>

        @foreach($report->updates->sortByDesc('created_at') as $update)
            <div class="border p-3 mb-2">
                <div class="d-flex justify-content-between gap-3 flex-wrap mb-2">
                    <strong>
                        {{ $update->technician->name ?? 'Teknisi' }}
                    </strong>

                    <small class="text-black-50">
                        {{ $update->created_at ? $update->created_at->format('d M Y H:i') : '-' }}
                    </small>
                </div>

                <div class="mb-2">
                    @if($update->status === 'assigned')
                        <span class="badge bg-info rounded-0">
                            Ditugaskan
                        </span>
                    @elseif($update->status === 'in_progress')
                        <span class="badge bg-primary rounded-0">
                            Sedang Dikerjakan
                        </span>
                    @elseif($update->status === 'completed')
                        <span class="badge bg-success rounded-0">
                            Selesai
                        </span>
                    @else
                        <span class="badge bg-secondary rounded-0">
                            {{ $update->status }}
                        </span>
                    @endif
                </div>

                <p class="text-dark mb-0">
                    {{ $update->note }}
                </p>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-light border rounded-0 mt-4 mb-0">
        Belum ada catatan dari teknisi.
    </div>
@endif