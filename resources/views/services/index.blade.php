<x-app-layout>
    <x-slot name="header">Jenis Layanan</x-slot>

    <div class="card">
        <div class="card-header">
            <span class="card-title">🧴 Daftar Jenis Layanan</span>
            <a href="{{ route('services.create') }}" class="btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                Tambah Layanan
            </a>
        </div>

        <div style="overflow-x:auto; border-radius:0 0 16px 16px;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Layanan</th>
                        <th style="text-align:right;">Harga Normal/Kg</th>
                        <th style="text-align:right;">Harga Express/Kg</th>
                        <th style="text-align:center;">Durasi</th>
                        <th>Deskripsi</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td style="color:#94a3b8; font-size:12px;">{{ $loop->iteration + ($services->currentPage() - 1) * $services->perPage() }}</td>
                            <td>
                                <div style="font-weight:700; color:#1e293b;">{{ $service->name }}</div>
                                @if($service->is_express)
                                    <span style="font-size:10px; font-weight:700; background:#fef3c7; color:#b45309; padding:2px 6px; border-radius:4px;">⚡ EXPRESS</span>
                                @endif
                            </td>
                            <td style="text-align:right; font-weight:600; color:#374151;">Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}</td>
                            <td style="text-align:right; font-weight:600; color:#d97706;">
                                @if($service->is_express)
                                    <span style="color:#b45309;">Rp {{ number_format($service->price_per_kg * 1.5, 0, ',', '.') }}</span>
                                @else
                                    Rp {{ number_format($service->price_per_kg * 1.5, 0, ',', '.') }}
                                    <span style="font-size:10px; color:#94a3b8;">(+50%)</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <span style="font-weight:600; color:#1a6fc4;">{{ $service->duration_days }}</span>
                                <span style="font-size:11px; color:#94a3b8;"> hari</span>
                            </td>
                            <td style="color:#64748b; font-size:13px; max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $service->description ?? '-' }}</td>
                            <td>
                                <div style="display:flex; gap:6px; justify-content:center;">
                                    <a href="{{ route('services.edit', $service) }}" class="btn-primary" style="padding:5px 12px; font-size:12px;">Edit</a>
                                    <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Hapus layanan ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-danger" style="padding:5px 12px; font-size:12px;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:48px; color:#94a3b8;">
                                <div style="font-size:40px; margin-bottom:8px;">🧴</div>
                                <div style="font-weight:600;">Belum ada layanan ditambahkan</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding:16px 24px;">{{ $services->links() }}</div>
    </div>
</x-app-layout>
