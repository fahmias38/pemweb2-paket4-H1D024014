<x-app-layout>
    <x-slot name="header">Detail Order — {{ $order->order_code }}</x-slot>

    @php
        $badgeMap = ['diterima'=>'badge-diterima','dicuci'=>'badge-dicuci','dikeringkan'=>'badge-dikeringkan','disetrika'=>'badge-disetrika','siap_diambil'=>'badge-siap','selesai'=>'badge-selesai'];
        $icons = ['diterima'=>'🧾','dicuci'=>'🫧','dikeringkan'=>'💨','disetrika'=>'👔','siap_diambil'=>'✅','selesai'=>'🏁'];
    @endphp

    <!-- Action bar -->
    <div style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
        <a href="{{ route('orders.index') }}" class="btn-secondary">← Kembali</a>
        @if(auth()->user()->role !== 'pelanggan')
            <a href="{{ route('orders.edit', $order) }}" class="btn-primary">✏️ Edit Order</a>
            <a href="{{ route('orders.nota', $order) }}" target="_blank" class="btn-success">🖨️ Cetak Nota</a>
        @endif
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:20px;">
        <!-- Customer Info -->
        <div class="card">
            <div class="card-header"><span class="card-title">👤 Data Pelanggan</span></div>
            <div class="card-body">
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <div>
                        <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px;">Nama</div>
                        <div style="font-size:15px; font-weight:700; color:#1e293b; margin-top:2px;">{{ $order->customer->name }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px;">No. HP</div>
                        <div style="font-size:14px; color:#374151; margin-top:2px;">{{ $order->customer->phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px;">Alamat</div>
                        <div style="font-size:13px; color:#64748b; margin-top:2px;">{{ $order->customer->address ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Info -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">📋 Info Order</span>
                <span class="badge {{ $badgeMap[$order->status] ?? '' }}" style="font-size:13px; padding:6px 14px;">
                    {{ $icons[$order->status] ?? '' }} {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                </span>
            </div>
            <div class="card-body">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px;">Kode Order</div>
                        <div style="font-size:14px; font-weight:700; color:#1a6fc4; font-family:monospace; margin-top:2px;">{{ $order->order_code }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px;">Diterima Oleh</div>
                        <div style="font-size:13px; color:#374151; margin-top:2px;">{{ $order->receivedBy->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px;">Tanggal Terima</div>
                        <div style="font-size:13px; color:#374151; margin-top:2px;">{{ $order->received_at ? $order->received_at->format('d M Y') : '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px;">Est. Selesai</div>
                        <div style="font-size:13px; font-weight:600; color:#10b981; margin-top:2px;">{{ $order->estimated_finish_date ? $order->estimated_finish_date->format('d M Y') : '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px;">Total Berat</div>
                        <div style="font-size:13px; color:#374151; margin-top:2px;">{{ $order->total_weight }} Kg</div>
                    </div>
                    <div>
                        <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px;">Total Bayar</div>
                        <div style="font-size:16px; font-weight:800; color:#1a6fc4; margin-top:2px;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                    </div>
                </div>
                @if($order->notes)
                    <div style="margin-top:14px; padding:10px 14px; background:#fffbeb; border-radius:8px; border:1px solid #fde68a;">
                        <span style="font-size:11px; font-weight:700; color:#92400e; text-transform:uppercase;">📝 Catatan:</span>
                        <p style="font-size:13px; color:#78350f; margin-top:4px;">{{ $order->notes }}</p>
                    </div>
                @endif
                @if($order->payment_proof)
                    <div style="margin-top:10px;">
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="btn-success" style="padding:6px 14px; font-size:12px;">📎 Lihat Bukti Pembayaran</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="card" style="margin-bottom:16px;">
        <div class="card-header"><span class="card-title">🧺 Rincian Item Laundry</span></div>
        <div style="overflow-x:auto; border-radius:0 0 16px 16px;">
            <table class="data-table">
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
                            <td style="color:#94a3b8; font-size:12px;">{{ $i + 1 }}</td>
                            <td>
                                <span style="font-weight:600;">{{ $item->service->name }}</span>
                                @if($item->service->is_express)
                                    <span style="font-size:10px; font-weight:700; background:#fef3c7; color:#b45309; padding:2px 6px; border-radius:4px; margin-left:6px;">EXPRESS +50%</span>
                                @endif
                            </td>
                            <td style="text-align:right; color:#64748b;">Rp {{ number_format($item->price_per_kg, 0, ',', '.') }}</td>
                            <td style="text-align:right; color:#64748b;">{{ number_format($item->weight, 2) }}</td>
                            <td style="text-align:right; font-weight:700; color:#1a6fc4;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:#f0f7ff;">
                        <td colspan="3" style="text-align:right; font-weight:700; font-size:13px; color:#374151; padding:14px 16px;">TOTAL</td>
                        <td style="text-align:right; font-weight:700; color:#374151; padding:14px 16px;">{{ $order->total_weight }} Kg</td>
                        <td style="text-align:right; font-weight:900; color:#1a6fc4; font-size:15px; padding:14px 16px;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Status History -->
    <div class="card">
        <div class="card-header"><span class="card-title">🕐 Riwayat Status</span></div>
        <div class="card-body">
            @forelse($order->histories()->latest()->get() as $history)
                <div style="display:flex; align-items:flex-start; gap:14px; padding:12px 0; border-bottom:1px solid #f1f5ff;">
                    <div style="width:10px; height:10px; border-radius:50%; background:#1a6fc4; flex-shrink:0; margin-top:5px;"></div>
                    <div style="flex:1;">
                        <div style="font-size:13px; font-weight:600; color:#1e293b;">
                            @if($history->old_status)
                                <span style="color:#64748b;">{{ strtoupper(str_replace('_',' ',$history->old_status)) }}</span>
                                <span style="color:#1a6fc4; font-weight:900;"> → </span>
                            @endif
                            <span class="badge {{ $badgeMap[$history->new_status] ?? 'badge-selesai' }}">
                                {{ strtoupper(str_replace('_',' ',$history->new_status)) }}
                            </span>
                        </div>
                        <div style="font-size:11px; color:#94a3b8; margin-top:3px;">
                            {{ $history->created_at ? $history->created_at->format('d M Y, H:i') : '-' }}
                            · oleh <strong style="color:#64748b;">{{ $history->changedBy->name ?? '-' }}</strong>
                            @if($history->notes) · {{ $history->notes }} @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align:center; color:#94a3b8; padding:24px;">Belum ada riwayat status.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
