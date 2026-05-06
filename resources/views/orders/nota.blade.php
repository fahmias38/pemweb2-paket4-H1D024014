<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Order — {{ $order->order_code }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 13px; color: #1e293b; background: #fff; }

        .nota-wrap { max-width: 700px; margin: 0 auto; padding: 32px 40px; }

        /* Header */
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px; padding-bottom: 20px; border-bottom: 3px solid #1a6fc4; }
        .brand-name { font-size: 28px; font-weight: 900; color: #1a6fc4; letter-spacing: -0.5px; }
        .brand-tagline { font-size: 11px; color: #64748b; margin-top: 2px; }
        .nota-label { text-align: right; }
        .nota-label h2 { font-size: 20px; font-weight: 800; color: #1e293b; }
        .nota-label .nota-code { font-size: 14px; color: #1a6fc4; font-weight: 700; font-family: monospace; margin-top: 2px; }
        .nota-label .nota-date { font-size: 11px; color: #64748b; margin-top: 4px; }

        /* Info grid */
        .info-grid { display: flex; gap: 20px; margin-bottom: 24px; }
        .info-box { flex: 1; background: #f8faff; border-radius: 10px; padding: 14px 16px; border: 1px solid #e8f0ff; }
        .info-box h4 { font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .info-key { font-size: 12px; color: #64748b; }
        .info-val { font-size: 12px; color: #1e293b; font-weight: 600; }

        /* Status badge */
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .status-diterima    { background: #dbeafe; color: #1d4ed8; }
        .status-dicuci      { background: #e0f2fe; color: #0369a1; }
        .status-dikeringkan { background: #fef3c7; color: #d97706; }
        .status-disetrika   { background: #f3e8ff; color: #7c3aed; }
        .status-siap_diambil{ background: #d1fae5; color: #047857; }
        .status-selesai     { background: #f1f5f9; color: #475569; }

        /* Items table */
        .section-title { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 10px; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table.items thead tr { background: #1a6fc4; }
        table.items th { padding: 10px 12px; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; }
        table.items th:last-child { text-align: right; }
        table.items td { padding: 10px 12px; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        table.items td:last-child { text-align: right; font-weight: 600; }
        table.items tr:nth-child(even) { background: #f8faff; }
        .express-tag { font-size: 9px; font-weight: 700; background: #fef3c7; color: #b45309; padding: 2px 5px; border-radius: 4px; margin-left: 5px; }

        /* Summary */
        .summary { display: flex; justify-content: flex-end; margin-bottom: 24px; }
        .summary-box { width: 280px; }
        .summary-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        .summary-row.total { border-top: 2px solid #1a6fc4; border-bottom: none; padding-top: 10px; margin-top: 4px; }
        .summary-row.total .label { font-weight: 800; font-size: 14px; color: #1e293b; }
        .summary-row.total .value { font-weight: 900; font-size: 16px; color: #1a6fc4; }

        /* Notes & proof */
        .notes-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 12px; color: #78350f; }
        .notes-box strong { display: block; margin-bottom: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }

        /* Timeline */
        .timeline { margin-bottom: 24px; }
        .timeline-item { display: flex; align-items: flex-start; gap: 12px; padding: 8px 0; }
        .timeline-dot { width: 10px; height: 10px; border-radius: 50%; background: #1a6fc4; flex-shrink: 0; margin-top: 3px; }
        .timeline-content { font-size: 12px; }
        .timeline-content strong { color: #1e293b; }
        .timeline-content span { color: #64748b; display: block; font-size: 11px; margin-top: 1px; }

        /* Footer */
        .footer { border-top: 2px solid #e8f0ff; padding-top: 18px; text-align: center; }
        .footer p { font-size: 11px; color: #94a3b8; margin-bottom: 3px; }
        .footer .thankyou { font-size: 14px; font-weight: 700; color: #1a6fc4; margin-bottom: 6px; }

        /* Print button */
        .print-btn { position: fixed; bottom: 24px; right: 24px; background: #1a6fc4; color: #fff; border: none; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px rgba(26,111,196,0.4); }
        @media print { .print-btn { display: none; } }
    </style>
</head>
<body>
<div class="nota-wrap">
    <!-- Header -->
    <div class="header">
        <div>
            <div class="brand-name">🫧 CleanPro</div>
            <div class="brand-tagline">Laundry Management System — BersihCepat Grendeng</div>
        </div>
        <div class="nota-label">
            <h2>NOTA LAUNDRY</h2>
            <div class="nota-code">{{ $order->order_code }}</div>
            <div class="nota-date">Dicetak: {{ now()->format('d F Y, H:i') }}</div>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="info-grid">
        <div class="info-box">
            <h4>📋 Info Order</h4>
            <div class="info-row">
                <span class="info-key">Kode Order</span>
                <span class="info-val" style="font-family:monospace; color:#1a6fc4;">{{ $order->order_code }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Tanggal Terima</span>
                <span class="info-val">{{ $order->received_at ? $order->received_at->format('d M Y') : '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Est. Selesai</span>
                <span class="info-val">{{ $order->estimated_finish_date ? $order->estimated_finish_date->format('d M Y') : '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Status</span>
                <span class="status-badge status-{{ $order->status }}">{{ strtoupper(str_replace('_', ' ', $order->status)) }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Diterima Oleh</span>
                <span class="info-val">{{ $order->receivedBy->name ?? '-' }}</span>
            </div>
        </div>
        <div class="info-box">
            <h4>👤 Data Pelanggan</h4>
            <div class="info-row">
                <span class="info-key">Nama</span>
                <span class="info-val">{{ $order->customer->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">No. HP</span>
                <span class="info-val">{{ $order->customer->phone }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Alamat</span>
                <span class="info-val" style="text-align:right; max-width:160px;">{{ $order->customer->address ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="section-title">Rincian Layanan</div>
    <table class="items">
        <thead>
            <tr>
                <th>#</th>
                <th>Layanan</th>
                <th style="text-align:right;">Harga/Kg</th>
                <th style="text-align:right;">Berat (Kg)</th>
                <th style="text-align:right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $i => $item)
                <tr>
                    <td style="color:#94a3b8; font-size:11px;">{{ $i + 1 }}</td>
                    <td>
                        {{ $item->service->name }}
                        @if($item->service->is_express)
                            <span class="express-tag">EXPRESS +50%</span>
                        @endif
                    </td>
                    <td style="text-align:right; color:#64748b;">Rp {{ number_format($item->price_per_kg, 0, ',', '.') }}</td>
                    <td style="text-align:right; color:#64748b;">{{ number_format($item->weight, 2) }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary">
        <div class="summary-box">
            <div class="summary-row">
                <span class="label" style="color:#64748b;">Total Berat</span>
                <span>{{ number_format($order->total_weight, 2) }} Kg</span>
            </div>
            <div class="summary-row total">
                <span class="label">TOTAL BAYAR</span>
                <span class="value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    @if($order->notes)
        <div class="notes-box">
            <strong>📝 Catatan</strong>
            {{ $order->notes }}
        </div>
    @endif

    @if($order->histories->count() > 0)
        <div class="section-title">Riwayat Status</div>
        <div class="timeline">
            @foreach($order->histories->sortByDesc('created_at') as $h)
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <strong>
                            {{ $h->old_status ? strtoupper(str_replace('_', ' ', $h->old_status)) . ' → ' : '' }}
                            {{ strtoupper(str_replace('_', ' ', $h->new_status)) }}
                        </strong>
                        <span>{{ $h->created_at ? $h->created_at->format('d M Y, H:i') : '-' }} · oleh {{ $h->changedBy->name ?? 'Sistem' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div class="thankyou">Terima kasih telah mempercayakan laundry Anda kepada kami! 🫧</div>
        <p>CleanPro — BersihCepat Grendeng | Laundry cepat, bersih, dan terpercaya</p>
        <p>Nota ini sah sebagai tanda terima resmi pesanan laundry Anda.</p>
    </div>
</div>

<button class="print-btn" onclick="window.print()">🖨️ Cetak Nota</button>

</body>
</html>
