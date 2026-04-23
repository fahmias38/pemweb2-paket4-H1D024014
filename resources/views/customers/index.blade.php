<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">List of Customers</h3>
                        <a href="{{ route('customers.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Add Customer</a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="py-2 px-4 text-left">#</th>
                                    <th class="py-2 px-4 text-left">Name</th>
                                    <th class="py-2 px-4 text-left">Phone</th>
                                    <th class="py-2 px-4 text-left">Address</th>
                                    <th class="py-2 px-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                    <tr class="border-b">
                                        <td class="py-2 px-4">{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                                        <td class="py-2 px-4">{{ $customer->name }}</td>
                                        <td class="py-2 px-4">{{ $customer->phone ?? '-' }}</td>
                                        <td class="py-2 px-4">{{ $customer->address ?? '-' }}</td>
                                        <td class="py-2 px-4 text-center space-x-2">
                                            <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-gray-500">No customers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
