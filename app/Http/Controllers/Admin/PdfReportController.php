<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Feedback;
use App\Models\MaintenanceReport;
use App\Models\Payment;
use App\Models\Tenant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PdfReportController extends Controller
{
    public function bookings(Request $request): Response
    {
        $records = Booking::query()
            ->with(['user', 'room', 'payment'])
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where(
                    'status',
                    $request->string('status')->toString()
                )
            )
            ->latest()
            ->get();

        return $this->renderPdf(
            view: 'pdf.reports.bookings',
            data: [
                'title' => 'Laporan Pemesanan Kamar',
                'records' => $records,
                'generatedAt' => now(),
            ],
            filename: 'laporan-pemesanan-' . now()->format('Y-m-d-His') . '.pdf',
            orientation: 'landscape',
        );
    }

    public function payments(Request $request): Response
    {
        $records = Payment::query()
            ->with(['booking.user', 'booking.room'])
            ->when(
                $request->filled('payment_method'),
                fn ($query) => $query->where(
                    'payment_method',
                    $request->string('payment_method')->toString()
                )
            )
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where(
                    'status',
                    $request->string('status')->toString()
                )
            )
            ->latest()
            ->get();

        return $this->renderPdf(
            view: 'pdf.reports.payments',
            data: [
                'title' => 'Laporan Pembayaran',
                'records' => $records,
                'totalAmount' => $records
                    ->where('status', 'verified')
                    ->sum('amount'),
                'generatedAt' => now(),
            ],
            filename: 'laporan-pembayaran-' . now()->format('Y-m-d-His') . '.pdf',
            orientation: 'landscape',
        );
    }

    public function tenants(Request $request): Response
    {
        $records = Tenant::query()
            ->with(['room', 'booking', 'user'])
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where(
                    'status',
                    $request->string('status')->toString()
                )
            )
            ->latest()
            ->get();

        return $this->renderPdf(
            view: 'pdf.reports.tenants',
            data: [
                'title' => 'Laporan Data Penghuni',
                'records' => $records,
                'generatedAt' => now(),
            ],
            filename: 'laporan-penghuni-' . now()->format('Y-m-d-His') . '.pdf',
            orientation: 'landscape',
        );
    }

    public function maintenance(Request $request): Response
    {
        $records = MaintenanceReport::query()
            ->with(['user', 'room', 'assignedTechnician'])
            ->when(
                $request->filled('priority'),
                fn ($query) => $query->where(
                    'priority',
                    $request->string('priority')->toString()
                )
            )
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where(
                    'status',
                    $request->string('status')->toString()
                )
            )
            ->latest()
            ->get();

        return $this->renderPdf(
            view: 'pdf.reports.maintenance',
            data: [
                'title' => 'Laporan Maintenance',
                'records' => $records,
                'generatedAt' => now(),
            ],
            filename: 'laporan-maintenance-' . now()->format('Y-m-d-His') . '.pdf',
            orientation: 'landscape',
        );
    }

    public function feedback(Request $request): Response
    {
        $records = Feedback::query()
            ->with(['user', 'booking.room'])
            ->when(
                $request->filled('rating'),
                fn ($query) => $query->where(
                    'rating',
                    $request->integer('rating')
                )
            )
            ->latest()
            ->get();

        return $this->renderPdf(
            view: 'pdf.reports.feedback',
            data: [
                'title' => 'Laporan Feedback Penghuni',
                'records' => $records,
                'averageRating' => round(
                    (float) $records->avg('rating'),
                    2
                ),
                'generatedAt' => now(),
            ],
            filename: 'laporan-feedback-' . now()->format('Y-m-d-His') . '.pdf',
            orientation: 'landscape',
        );
    }

    private function renderPdf(
        string $view,
        array $data,
        string $filename,
        string $orientation = 'portrait',
    ): Response {
        $pdf = Pdf::loadView($view, $data)
            ->setPaper('a4', $orientation)
            ->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'isPhpEnabled' => false,
                'dpi' => 120,
            ]);

        return $pdf->stream($filename, [
            'Attachment' => false,
        ]);
    }
}