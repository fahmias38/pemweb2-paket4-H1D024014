<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">List of Orders</h3>
                        @if(auth()->user()->role !== 'pelanggan')
                            <a href="{{ route('orders.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Add Order</a>
                        @endif
                    </div>

                    <!-- Search Form -->
                    <form action="{{ route('orders.index') }}" method="GET" class="mb-4">
                        <div class="flex space-x-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order Code" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Search</button>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="py-2 px-4 text-left">Order Code</th>
                                    <th class="py-2 px-4 text-left">Customer</th>
                                    <th class="py-2 px-4 text-left">Status</th>
                                    <th class="py-2 px-4 text-left">Est. Finish</th>
                                    <th class="py-2 px-4 text-left">Total Amount</th>
                                    <th class="py-2 px-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr class="border-b">
                                        <td class="py-2 px-4">{{ $order->order_code }}</td>
                                        <td class="py-2 px-4">{{ $order->customer->name }}</td>
                                        <td class="py-2 px-4">
                                            <span class="px-2 py-1 text-xs rounded bg-gray-200">{{ strtoupper(str_replace('_', ' ', $order->status)) }}</span>
                                        </td>
                                        <td class="py-2 px-4">{{ $order->estimated_finish_date->format('d M Y') }}</td>
                                        <td class="py-2 px-4">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 text-center space-x-2">
                                            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                                            @if(auth()->user()->role !== 'pelanggan')
                                                <a href="{{ route('orders.edit', $order) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                                                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 text-center text-gray-500">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
