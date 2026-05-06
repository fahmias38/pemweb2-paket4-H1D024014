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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Order Items</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="py-2 px-4 text-left">Service</th>
                                    <th class="py-2 px-4 text-right">Price/Kg</th>
                                    <th class="py-2 px-4 text-right">Weight (Kg)</th>
                                    <th class="py-2 px-4 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr class="border-b">
                                        <td class="py-2 px-4">{{ $item->service->name }} {{ $item->service->is_express ? '(Express)' : '' }}</td>
                                        <td class="py-2 px-4 text-right">Rp {{ number_format($item->price_per_kg, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 text-right">{{ $item->weight }}</td>
                                        <td class="py-2 px-4 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="font-bold bg-gray-50">
                                    <td colspan="2" class="py-2 px-4 text-right">Total</td>
                                    <td class="py-2 px-4 text-right">{{ $order->total_weight }} Kg</td>
                                    <td class="py-2 px-4 text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Back to List</a>
            </div>
        </div>
    </div>
</x-app-layout>
