<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Order (CP4 Simple)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="order_code" class="block text-sm font-medium text-gray-700">Order Code</label>
                            <input type="text" name="order_code" id="order_code" value="{{ old('order_code') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('order_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                            <select name="customer_id" id="customer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="received_at" class="block text-sm font-medium text-gray-700">Received At</label>
                            <input type="date" name="received_at" id="received_at" value="{{ old('received_at', \Carbon\Carbon::now()->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('received_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4 p-4 border rounded bg-gray-50">
                            <h4 class="font-bold mb-2">Order Items</h4>
                            <div id="items-container">
                                @if(old('items'))
                                    @foreach(old('items') as $index => $item)
                                        <div class="item-row flex space-x-2 mb-2">
                                            <select name="items[{{ $index }}][service_id]" required class="w-2/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="">Select Service</option>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}" {{ $item['service_id'] == $service->id ? 'selected' : '' }}>
                                                        {{ $service->name }} (Rp {{ number_format($service->is_express ? $service->price_per_kg * 1.5 : $service->price_per_kg, 0, ',', '.') }}/kg)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="number" step="0.1" name="items[{{ $index }}][weight]" value="{{ $item['weight'] }}" placeholder="Weight (Kg)" required class="w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <button type="button" class="remove-item px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">X</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="item-row flex space-x-2 mb-2">
                                        <select name="items[0][service_id]" required class="w-2/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Service</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}">
                                                    {{ $service->name }} (Rp {{ number_format($service->is_express ? $service->price_per_kg * 1.5 : $service->price_per_kg, 0, ',', '.') }}/kg)
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="number" step="0.1" name="items[0][weight]" placeholder="Weight (Kg)" required class="w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <button type="button" class="remove-item px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600" style="display: none;">X</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add-item" class="mt-2 px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm">+ Add Item</button>
                            @error('items') <span class="text-red-500 text-sm block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                let itemIndex = {{ old('items') ? count(old('items')) : 1 }};
                                const container = document.getElementById('items-container');
                                const addButton = document.getElementById('add-item');

                                addButton.addEventListener('click', function() {
                                    const row = document.createElement('div');
                                    row.className = 'item-row flex space-x-2 mb-2';
                                    row.innerHTML = `
                                        <select name="items[${itemIndex}][service_id]" required class="w-2/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Service</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}">
                                                    {{ $service->name }} (Rp {{ number_format($service->is_express ? $service->price_per_kg * 1.5 : $service->price_per_kg, 0, ',', '.') }}/kg)
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="number" step="0.1" name="items[${itemIndex}][weight]" placeholder="Weight (Kg)" required class="w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <button type="button" class="remove-item px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">X</button>
                                    `;
                                    container.appendChild(row);
                                    itemIndex++;
                                    updateRemoveButtons();
                                });

                                container.addEventListener('click', function(e) {
                                    if (e.target.classList.contains('remove-item')) {
                                        e.target.closest('.item-row').remove();
                                        updateRemoveButtons();
                                    }
                                });

                                function updateRemoveButtons() {
                                    const rows = container.querySelectorAll('.item-row');
                                    rows.forEach((row, index) => {
                                        const btn = row.querySelector('.remove-item');
                                        if (rows.length === 1) {
                                            btn.style.display = 'none';
                                        } else {
                                            btn.style.display = 'block';
                                        }
                                    });
                                }
                                updateRemoveButtons();
                            });
                        </script>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @foreach(['diterima', 'dicuci', 'dikeringkan', 'disetrika', 'siap_diambil', 'selesai'] as $status)
                                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                        {{ strtoupper(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="payment_proof" class="block text-sm font-medium text-gray-700">Bukti Pembayaran / Foto Item (Opsional)</label>
                            <input type="file" name="payment_proof" id="payment_proof" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('payment_proof') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                            @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
