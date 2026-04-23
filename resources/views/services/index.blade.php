<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Services') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">List of Services</h3>
                        <a href="{{ route('services.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Add Service</a>
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
                                    <th class="py-2 px-4 text-left">Price / Kg</th>
                                    <th class="py-2 px-4 text-left">Description</th>
                                    <th class="py-2 px-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $service)
                                    <tr class="border-b">
                                        <td class="py-2 px-4">{{ $loop->iteration + ($services->currentPage() - 1) * $services->perPage() }}</td>
                                        <td class="py-2 px-4">{{ $service->name }}</td>
                                        <td class="py-2 px-4">Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4">{{ $service->description ?? '-' }}</td>
                                        <td class="py-2 px-4 text-center space-x-2">
                                            <a href="{{ route('services.edit', $service) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                                            <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-gray-500">No services found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
