<x-app-layout>
    <x-slot name="header">Daftar Order</x-slot>

    <div class="card">
        <div class="card-header">
            <span class="card-title">📋 Semua Order Laundry</span>
            @if(auth()->user()->role !== 'pelanggan')
                <a href="{{ route('orders.create') }}" class="btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                    Terima Order Baru
                </a>
            @endif
        </div>

        <div class="card-body" style="padding: 16px 24px;">
            <!-- Search & Filter -->
            <form action="{{ route('orders.index') }}" method="GET">
                <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom: 16px;">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="🔍  Cari kode order..."
                           class="form-input" style="max-width:220px;">

                    <select name="status" class="form-input" style="max-width:200px;">
                        <option value="">Semua Status</option>
                        @foreach(['diterima'=>'Diterima','dicuci'=>'Dicuci','dikeringkan'=>'Dikeringkan','disetrika'=>'Disetrika','siap_diambil'=>'Siap Diambil','selesai'=>'Selesai'] as $val => $label)
                            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-primary" style="padding:9px 16px;">Filter</button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('orders.index') }}" class="btn-secondary">Reset</a>
                    @endif
                </div>
            </form>

            <!-- Table -->
            <div style="overflow-x: auto; border-radius: 12px; border: 1.5px solid #e8f0ff;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode Order</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th>Diterima</th>
                            <th>Est. Selesai</th>
                            <th>Total</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $badgeMap = ['diterima'=>'badge-diterima','dicuci'=>'badge-dicuci','dikeringkan'=>'badge-dikeringkan','disetrika'=>'badge-disetrika','siap_diambil'=>'badge-siap','selesai'=>'badge-selesai'];
                            $icons = ['diterima'=>'🧾','dicuci'=>'🫧','dikeringkan'=>'💨','disetrika'=>'👔','siap_diambil'=>'✅','selesai'=>'🏁'];
                        @endphp
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <span style="font-weight:700; color:#1a6fc4; font-family:monospace; font-size:13px;">
                                        {{ $order->order_code }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#1e293b;">{{ $order->customer->name }}</div>
                                    <div style="font-size:11px; color:#94a3b8;">{{ $order->customer->phone }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $badgeMap[$order->status] ?? 'badge-selesai' }}">
                                        {{ $icons[$order->status] ?? '' }} {{ str_replace('_', ' ', strtoupper($order->status)) }}
                                    </span>
                                </td>
                                <td style="color:#64748b; font-size:13px;">{{ $order->received_at ? $order->received_at->format('d M Y') : '-' }}</td>
                                <td style="font-weight:600; color:#374151;">{{ $order->estimated_finish_date ? $order->estimated_finish_date->format('d M Y') : '-' }}</td>
                                <td style="font-weight:700; color:#1a6fc4;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    <div style="display:flex; gap:6px; justify-content:center; flex-wrap:wrap;">
                                        <a href="{{ route('orders.show', $order) }}" class="btn-secondary" style="padding:5px 10px; font-size:12px;">Detail</a>
                                        @if(auth()->user()->role !== 'pelanggan')
                                            <a href="{{ route('orders.edit', $order) }}" class="btn-primary" style="padding:5px 10px; font-size:12px;">Edit</a>
                                            <a href="{{ route('orders.nota', $order) }}" target="_blank" class="btn-success" style="padding:5px 10px; font-size:12px;">🖨️ Nota</a>
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Hapus order ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn-danger" style="padding:5px 10px; font-size:12px;">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:48px; color:#94a3b8;">
                                    <div style="font-size:40px; margin-bottom:8px;">🧺</div>
                                    <div style="font-weight:600;">Belum ada order ditemukan</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 16px;">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
