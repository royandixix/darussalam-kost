<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>{{ $title ?? 'Laporan Kosan Darussalam' }}</title>

    <style>
        @page {
            margin: 25px 28px 45px 28px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #1f2937;
            line-height: 1.35;
        }

        table {
            border-collapse: collapse;
        }

        .header-table {
            width: 100%;
            margin-bottom: 8px;
            border-bottom: 3px solid #166534;
        }

        .header-table td {
            border: none;
            padding: 0 0 10px 0;
            vertical-align: middle;
        }

        .logo-cell {
            width: 75px;
            text-align: left;
        }

        .logo {
            width: 60px;
            height: auto;
        }

        .institution-cell {
            padding-left: 10px !important;
        }

        .institution-name {
            margin: 0;
            color: #14532d;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .institution-subtitle {
            margin-top: 3px;
            color: #4b5563;
            font-size: 9px;
        }

        .document-cell {
            width: 160px;
            color: #6b7280;
            font-size: 8px;
            text-align: right;
        }

        .document-title {
            margin-top: 18px;
            text-align: center;
        }

        .document-title h1 {
            margin: 0;
            color: #111827;
            font-size: 17px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .title-divider {
            width: 80px;
            height: 3px;
            margin: 7px auto;
            background-color: #16a34a;
        }

        .generated-time {
            color: #6b7280;
            font-size: 8px;
            text-align: center;
        }

        .summary-table {
            width: 100%;
            margin-top: 17px;
            margin-bottom: 14px;
        }

        .summary-table td {
            width: 25%;
            padding: 4px;
            border: none;
        }

        .summary-box {
            min-height: 48px;
            padding: 9px;
            border: 1px solid #d1d5db;
            background-color: #f8fafc;
        }

        .summary-label {
            margin-bottom: 4px;
            color: #6b7280;
            font-size: 7px;
            text-transform: uppercase;
        }

        .summary-value {
            color: #166534;
            font-size: 13px;
            font-weight: bold;
        }

        .report-table {
            width: 100%;
            table-layout: fixed;
        }

        .report-table thead {
            display: table-header-group;
        }

        .report-table tr {
            page-break-inside: avoid;
        }

        .report-table th {
            padding: 7px 4px;
            border: 1px solid #14532d;
            background-color: #166534;
            color: #ffffff;
            font-size: 7px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }

        .report-table td {
            padding: 6px 4px;
            border: 1px solid #d1d5db;
            font-size: 7.5px;
            vertical-align: top;
            word-break: break-word;
        }

        .report-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .muted {
            color: #6b7280;
        }

        .empty-state {
            margin-top: 20px;
            padding: 30px;
            border: 1px solid #d1d5db;
            color: #6b7280;
            text-align: center;
        }

        .signature-table {
            width: 100%;
            margin-top: 25px;
        }

        .signature-table td {
            width: 50%;
            border: none;
            vertical-align: top;
        }

        .signature-box {
            margin-left: 80px;
            text-align: center;
        }

        .signature-space {
            height: 55px;
        }

        .footer {
            position: fixed;
            right: 0;
            bottom: -30px;
            left: 0;
            padding-top: 5px;
            border-top: 1px solid #d1d5db;
            color: #6b7280;
            font-size: 7px;
        }

        .footer-table {
            width: 100%;
        }

        .footer-table td {
            border: none;
        }

        .footer-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @php
                    $logoPath = public_path('images/logo.png');
                @endphp

                @if (file_exists($logoPath))
                    <img
                        src="{{ $logoPath }}"
                        alt="Logo Kosan Darussalam"
                        class="logo"
                    >
                @endif
            </td>

            <td class="institution-cell">
                <div class="institution-name">
                    Kosan Darussalam
                </div>

                <div class="institution-subtitle">
                    Sistem Informasi Pemesanan, Feedback, dan Maintenance
                </div>
            </td>

            <td class="document-cell">
                DOKUMEN LAPORAN<br>
                {{ $generatedAt->format('Ymd-His') }}
            </td>
        </tr>
    </table>

    <div class="document-title">
        <h1>{{ $title }}</h1>

        <div class="title-divider"></div>

        <div class="generated-time">
            Dicetak pada
            {{ $generatedAt->translatedFormat('d F Y, H:i') }}
            WITA
        </div>
    </div>

    @yield('content')

    <table class="signature-table">
        <tr>
            <td></td>

            <td>
                <div class="signature-box">
                    Makassar,
                    {{ $generatedAt->translatedFormat('d F Y') }}

                    <br>
                    Administrator

                    <div class="signature-space"></div>

                    <strong>Pengelola Kosan Darussalam</strong>
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    Kosan Darussalam — Dicetak otomatis oleh sistem
                </td>

                <td class="footer-right">
                    {{ $title }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>