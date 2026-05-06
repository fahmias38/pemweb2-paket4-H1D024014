<x-app-layout>
    <x-slot name="header">Pelanggan</x-slot>

    <div class="card">
        <div class="card-header">
            <span class="card-title">👥 Daftar Pelanggan</span>
            <a href="{{ route('customers.create') }}" class="btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                Tambah Pelanggan
            </a>
        </div>

        <div class="card-body" style="padding: 16px 24px;">
            <form action="{{ route('customers.index') }}" method="GET">
                <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:16px;">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="🔍  Cari nama atau no. HP..."
                           class="form-input" style="max-width:280px;">
                    <button type="submit" class="btn-primary" style="padding:9px 16px;">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('customers.index') }}" class="btn-secondary">Reset</a>
                    @endif
                </div>
            </form>

            <div style="overflow-x:auto; border-radius:12px; border:1.5px solid #e8f0ff;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pelanggan</th>
                            <th>No. HP</th>
                            <th>Alamat</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td style="color:#94a3b8; font-size:12px;">{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div style="width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,#1a6fc4,#0891b2); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:14px; flex-shrink:0;">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>
                                        <span style="font-weight:600; color:#1e293b;">{{ $customer->name }}</span>
                                    </div>
                                </td>
                                <td style="color:#64748b;">{{ $customer->phone ?? '-' }}</td>
                                <td style="color:#64748b; font-size:13px; max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $customer->address ?? '-' }}</td>
                                <td>
                                    <div style="display:flex; gap:6px; justify-content:center;">
                                        <a href="{{ route('customers.edit', $customer) }}" class="btn-primary" style="padding:5px 12px; font-size:12px;">Edit</a>
                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pelanggan ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn-danger" style="padding:5px 12px; font-size:12px;">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding:48px; color:#94a3b8;">
                                    <div style="font-size:40px; margin-bottom:8px;">👥</div>
                                    <div style="font-weight:600;">Belum ada pelanggan ditemukan</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:16px;">{{ $customers->links() }}</div>
        </div>
    </div>
</x-app-layout>
