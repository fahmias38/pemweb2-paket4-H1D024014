<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details (CP4 Simple)') }} - {{ $order->order_code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-bold mb-2 border-b pb-2">Customer Info</h3>
                            <p><strong>Name:</strong> {{ $order->customer->name }}</p>
                            <p><strong>Phone:</strong> {{ $order->customer->phone ?? '-' }}</p>
                            <p><strong>Address:</strong> {{ $order->customer->address ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-2 border-b pb-2">Order Info</h3>
                            <p><strong>Status:</strong> <span class="px-2 py-1 text-xs rounded bg-gray-200">{{ strtoupper(str_replace('_', ' ', $order->status)) }}</span></p>
                            <p><strong>Received At:</strong> {{ $order->received_at ? $order->received_at->format('d M Y') : '-' }}</p>
                            <p><strong>Est. Finish:</strong> {{ $order->estimated_finish_date ? $order->estimated_finish_date->format('d M Y') : '-' }}</p>
                            <p><strong>Received By:</strong> {{ $order->receivedBy->name }}</p>
                            <p><strong>Total Weight:</strong> {{ $order->total_weight }} Kg</p>
                            <p><strong>Total Amount:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            <p><strong>Notes:</strong> {{ $order->notes ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Back to List</a>
            </div>
        </div>
    </div>
</x-app-layout>
