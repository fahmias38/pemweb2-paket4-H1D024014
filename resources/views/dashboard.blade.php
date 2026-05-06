<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    @php
        $user = auth()->user();
        $isPelanggan = $user->role === 'pelanggan';

        if ($isPelanggan) {
            // Pelanggan: hanya data order miliknya sendiri
            $customer = \App\Models\Customer::where('user_id', $user->id)->first();
            $myOrders   = $customer ? \App\Models\Order::where('customer_id', $customer->id) : collect();
            $totalOrders   = $customer ? \App\Models\Order::where('customer_id', $customer->id)->count() : 0;
            $activeOrders  = $customer ? \App\Models\Order::where('customer_id', $customer->id)->whereNotIn('status', ['selesai'])->count() : 0;
            $siapDiambil   = $customer ? \App\Models\Order::where('customer_id', $customer->id)->where('status', 'siap_diambil')->count() : 0;
            $selesai       = $customer ? \App\Models\Order::where('customer_id', $customer->id)->where('status', 'selesai')->count() : 0;
            $recentOrders  = $customer ? \App\Models\Order::where('customer_id', $customer->id)->with('customer')->latest()->take(5)->get() : collect();
        } else {
            // Admin / Kasir: data seluruh sistem
            $totalOrders   = \App\Models\Order::count();
            $todayOrders   = \App\Models\Order::whereDate('received_at', today())->count();
            $siapDiambil   = \App\Models\Order::where('status', 'siap_diambil')->count();
            $todayRevenue  = \App\Models\Order::where('status', 'selesai')->whereDate('updated_at', today())->sum('total_amount');
            $recentOrders  = \App\Models\Order::with('customer')->latest()->take(5)->get();
        }
    @endphp

    {{-- ============================================================ --}}
    {{-- VIEW PELANGGAN                                                --}}
    {{-- ============================================================ --}}
    @if($isPelanggan)

    @if(!$customer)
        <div style="text-align:center; padding:60px 20px;">
            <div style="width:60px; height:60px; border-radius:50%; background:#f1f5f9; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div style="font-size:16px; font-weight:700; color:#1e293b;">Akun Anda Belum Terdaftar</div>
            <p style="color:#64748b; font-size:13px; margin-top:6px;">Hubungi kasir atau admin untuk menghubungkan akun Anda dengan data pelanggan.</p>
        </div>
    @else

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:14px; margin-bottom:22px;">
        <div class="stat-card" style="background:#eff6ff; border-color:#bfdbfe;">
            <div class="stat-icon" style="background:#dbeafe;">
                <svg viewBox="0 0 24 24" stroke="#1d4ed8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
            </div>
            <div class="stat-value" style="color:#1d4ed8;">{{ $totalOrders }}</div>
            <div class="stat-label" style="color:#3b82f6;">Total Pesanan Saya</div>
        </div>
        <div class="stat-card" style="background:#f0fdf4; border-color:#bbf7d0;">
            <div class="stat-icon" style="background:#dcfce7;">
                <svg viewBox="0 0 24 24" stroke="#15803d"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="stat-value" style="color:#15803d;">{{ $siapDiambil }}</div>
            <div class="stat-label" style="color:#16a34a;">Siap Diambil</div>
        </div>
        <div class="stat-card" style="background:#fff7ed; border-color:#fed7aa;">
            <div class="stat-icon" style="background:#ffedd5;">
                <svg viewBox="0 0 24 24" stroke="#c2410c"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
            </div>
            <div class="stat-value" style="color:#c2410c;">{{ $activeOrders }}</div>
            <div class="stat-label" style="color:#ea580c;">Sedang Diproses</div>
        </div>
        <div class="stat-card" style="background:#f1f5f9; border-color:#cbd5e1;">
            <div class="stat-icon" style="background:#e2e8f0;">
                <svg viewBox="0 0 24 24" stroke="#475569"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div class="stat-value" style="color:#475569;">{{ $selesai }}</div>
            <div class="stat-label" style="color:#64748b;">Selesai</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Riwayat Pesanan Saya</span>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary" style="font-size:12px; padding:6px 12px;">Lihat Semua</a>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Order</th>
                        <th>Status</th>
                        <th>Tgl Terima</th>
                        <th>Est. Selesai</th>
                        <th>Total</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $badgeMap = ['diterima'=>'badge-diterima','dicuci'=>'badge-dicuci','dikeringkan'=>'badge-dikeringkan','disetrika'=>'badge-disetrika','siap_diambil'=>'badge-siap','selesai'=>'badge-selesai'];
                        $statusLabel = ['diterima'=>'Diterima','dicuci'=>'Dicuci','dikeringkan'=>'Dikeringkan','disetrika'=>'Disetrika','siap_diambil'=>'Siap Diambil','selesai'=>'Selesai'];
                    @endphp
                    @forelse($recentOrders as $order)
                        <tr>
                            <td style="font-weight:700; color:#1a6fc4; font-family:monospace;">{{ $order->order_code }}</td>
                            <td><span class="badge {{ $badgeMap[$order->status] ?? 'badge-selesai' }}">{{ $statusLabel[$order->status] ?? $order->status }}</span></td>
                            <td style="color:#64748b;">{{ $order->received_at ? $order->received_at->format('d M Y') : '-' }}</td>
                            <td style="font-weight:600;">{{ $order->estimated_finish_date ? $order->estimated_finish_date->format('d M Y') : '-' }}</td>
                            <td style="font-weight:700;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td style="text-align:center;"><a href="{{ route('orders.show', $order) }}" class="btn btn-primary" style="font-size:12px; padding:5px 12px;">Detail</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @endif {{-- end $customer check --}}

    {{-- ============================================================ --}}
    {{-- VIEW ADMIN / KASIR                                            --}}
    {{-- ============================================================ --}}
    @else

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:14px; margin-bottom:22px;">
        <div class="stat-card" style="background:#eff6ff; border-color:#bfdbfe;">
            <div class="stat-icon" style="background:#dbeafe;">
                <svg viewBox="0 0 24 24" stroke="#1d4ed8" fill="none" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
            </div>
            <div class="stat-value" style="color:#1d4ed8;">{{ $totalOrders }}</div>
            <div class="stat-label" style="color:#3b82f6;">Total Seluruh Order</div>
        </div>
        <div class="stat-card" style="background:#e0f2fe; border-color:#bae6fd;">
            <div class="stat-icon" style="background:#bae6fd;">
                <svg viewBox="0 0 24 24" stroke="#0369a1" fill="none" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="stat-value" style="color:#0369a1;">{{ $todayOrders }}</div>
            <div class="stat-label" style="color:#0284c7;">Order Hari Ini</div>
        </div>
        <div class="stat-card" style="background:#f0fdf4; border-color:#bbf7d0;">
            <div class="stat-icon" style="background:#dcfce7;">
                <svg viewBox="0 0 24 24" stroke="#15803d" fill="none" stroke-width="1.8"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="stat-value" style="color:#15803d;">{{ $siapDiambil }}</div>
            <div class="stat-label" style="color:#16a34a;">Siap Diambil</div>
        </div>
        <div class="stat-card" style="background:#fefce8; border-color:#fef08a;">
            <div class="stat-icon" style="background:#fef9c3;">
                <svg viewBox="0 0 24 24" stroke="#a16207" fill="none" stroke-width="1.8"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="stat-value" style="color:#a16207; font-size:20px;">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
            <div class="stat-label" style="color:#ca8a04;">Pendapatan Hari Ini</div>
        </div>
    </div>

    <!-- Workflow Overview -->
    <div class="card" style="margin-bottom:20px;">
        <div class="card-header">
            <span class="card-title">Status Workflow Order</span>
        </div>
        <div class="card-body" style="padding:18px 22px;">
            @php
                $statuses = [
                    'diterima'    => ['Diterima',    'badge-diterima',    '#1d4ed8'],
                    'dicuci'      => ['Dicuci',      'badge-dicuci',      '#0369a1'],
                    'dikeringkan' => ['Dikeringkan', 'badge-dikeringkan', '#b45309'],
                    'disetrika'   => ['Disetrika',   'badge-disetrika',   '#7c3aed'],
                    'siap_diambil'=> ['Siap Diambil','badge-siap',        '#15803d'],
                    'selesai'     => ['Selesai',     'badge-selesai',     '#475569'],
                ];
                $counts = \App\Models\Order::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
            @endphp
            <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                @foreach($statuses as $key => [$label, $badge, $color])
                    <div style="text-align:center; padding:12px 16px; background:#f8fafc; border:1px solid #e4eaf2; border-radius:10px; min-width:88px;">
                        <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">{{ $label }}</div>
                        <div style="font-size:24px; font-weight:800; color:{{ $color }};">{{ $counts[$key] ?? 0 }}</div>
                    </div>
                    @if(!$loop->last)
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">Order Terbaru</span>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary" style="font-size:12px; padding:6px 12px;">Lihat Semua</a>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Order</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th>Est. Selesai</th>
                        <th>Total</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $badgeMap = ['diterima'=>'badge-diterima','dicuci'=>'badge-dicuci','dikeringkan'=>'badge-dikeringkan','disetrika'=>'badge-disetrika','siap_diambil'=>'badge-siap','selesai'=>'badge-selesai'];
                        $statusLabel = ['diterima'=>'Diterima','dicuci'=>'Dicuci','dikeringkan'=>'Dikeringkan','disetrika'=>'Disetrika','siap_diambil'=>'Siap Diambil','selesai'=>'Selesai'];
                    @endphp
                    @forelse($recentOrders as $order)
                        <tr>
                            <td style="font-weight:700; color:#1a6fc4; font-family:monospace;">{{ $order->order_code }}</td>
                            <td>{{ $order->customer->name }}</td>
                            <td><span class="badge {{ $badgeMap[$order->status] ?? 'badge-selesai' }}">{{ $statusLabel[$order->status] ?? $order->status }}</span></td>
                            <td style="color:#64748b;">{{ $order->estimated_finish_date ? $order->estimated_finish_date->format('d M Y') : '-' }}</td>
                            <td style="font-weight:700;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td style="text-align:center;"><a href="{{ route('orders.show', $order) }}" class="btn btn-primary" style="font-size:12px; padding:5px 12px;">Detail</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;">Belum ada order.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @endif {{-- end role check --}}
</x-app-layout>
