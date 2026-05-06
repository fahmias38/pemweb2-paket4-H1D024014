<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    @php
        $totalOrders    = \App\Models\Order::count();
        $todayOrders    = \App\Models\Order::whereDate('received_at', today())->count();
        $siapDiambil    = \App\Models\Order::where('status', 'siap_diambil')->count();
        $todayRevenue   = \App\Models\Order::where('status', 'selesai')->whereDate('updated_at', today())->sum('total_amount');
        $recentOrders   = \App\Models\Order::with('customer')->latest()->take(5)->get();
    @endphp

    <!-- Stat Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div class="stat-card" style="background: linear-gradient(135deg,#1a6fc4,#1e90e0); color:#fff;">
            <div class="stat-icon" style="background:rgba(255,255,255,0.2);">📋</div>
            <div>
                <div class="stat-value" style="color:#fff;">{{ $totalOrders }}</div>
                <div class="stat-label" style="color:rgba(255,255,255,0.8);">Total Order</div>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg,#0891b2,#06b6d4); color:#fff;">
            <div class="stat-icon" style="background:rgba(255,255,255,0.2);">🧺</div>
            <div>
                <div class="stat-value" style="color:#fff;">{{ $todayOrders }}</div>
                <div class="stat-label" style="color:rgba(255,255,255,0.8);">Order Hari Ini</div>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg,#10b981,#34d399); color:#fff;">
            <div class="stat-icon" style="background:rgba(255,255,255,0.2);">✅</div>
            <div>
                <div class="stat-value" style="color:#fff;">{{ $siapDiambil }}</div>
                <div class="stat-label" style="color:rgba(255,255,255,0.8);">Siap Diambil</div>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg,#f59e0b,#fbbf24); color:#fff;">
            <div class="stat-icon" style="background:rgba(255,255,255,0.2);">💰</div>
            <div>
                <div class="stat-value" style="color:#fff; font-size:18px;">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
                <div class="stat-label" style="color:rgba(255,255,255,0.8);">Pendapatan Hari Ini</div>
            </div>
        </div>
    </div>

    <!-- Workflow Overview -->
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <span class="card-title">🔄 Alur Status Order</span>
        </div>
        <div class="card-body" style="padding: 20px 24px;">
            <div style="display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
                @php
                    $statuses = [
                        'diterima'    => ['🧾', 'Diterima',    'badge-diterima'],
                        'dicuci'      => ['🫧', 'Dicuci',      'badge-dicuci'],
                        'dikeringkan' => ['💨', 'Dikeringkan', 'badge-dikeringkan'],
                        'disetrika'   => ['👔', 'Disetrika',   'badge-disetrika'],
                        'siap_diambil'=> ['✅', 'Siap Diambil','badge-siap'],
                        'selesai'     => ['🏁', 'Selesai',     'badge-selesai'],
                    ];
                    $counts = \App\Models\Order::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
                @endphp
                @foreach($statuses as $key => [$icon, $label, $badgeClass])
                    <div style="display:flex; align-items:center; gap:4px;">
                        <div style="background:#f8faff; border:1.5px solid #e8f0ff; border-radius:12px; padding:10px 14px; text-align:center; min-width:90px;">
                            <div style="font-size:20px; margin-bottom:4px;">{{ $icon }}</div>
                            <div style="font-size:11px; font-weight:700; color:#374151;">{{ $label }}</div>
                            <div style="font-size:20px; font-weight:800; color:#1a6fc4; margin-top:2px;">{{ $counts[$key] ?? 0 }}</div>
                        </div>
                        @if(!$loop->last)
                            <svg style="color:#c5d9ff; flex-shrink:0;" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">📋 Order Terbaru</span>
            <a href="{{ route('orders.index') }}" class="btn-secondary" style="font-size:12px; padding:6px 14px;">Lihat Semua</a>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Order</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th>Est. Selesai</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td><span style="font-weight:700; color:#1a6fc4;">{{ $order->order_code }}</span></td>
                            <td>{{ $order->customer->name }}</td>
                            <td>
                                @php
                                    $badgeMap = ['diterima'=>'badge-diterima','dicuci'=>'badge-dicuci','dikeringkan'=>'badge-dikeringkan','disetrika'=>'badge-disetrika','siap_diambil'=>'badge-siap','selesai'=>'badge-selesai'];
                                @endphp
                                <span class="badge {{ $badgeMap[$order->status] ?? 'badge-selesai' }}">
                                    {{ str_replace('_', ' ', strtoupper($order->status)) }}
                                </span>
                            </td>
                            <td>{{ $order->estimated_finish_date ? $order->estimated_finish_date->format('d M Y') : '-' }}</td>
                            <td style="font-weight:600;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td><a href="{{ route('orders.show', $order) }}" class="btn-primary" style="font-size:12px; padding:5px 12px;">Detail</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center; color:#9ca3af; padding:32px;">Belum ada order.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
