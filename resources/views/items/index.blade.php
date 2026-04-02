@extends('layouts.app')
@section('title', 'Items')

@section('contents')
    <div class="container mx-auto px-4 py-8 max-w-6xl">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Items</h2>

            <a href="{{ route('items.create') }}"
                class="bg-slate-900 hover:bg-slate-700 text-white font-semibold py-2 px-4 rounded">
                Add Item
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">

                <thead class="bg-gray-200 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Item Code</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Item Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Standard Rate</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Valuation Rate</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Last Purchase Rate</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($items as $item)
                        <tr class="border-b hover:bg-gray-50">

                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $item['name'] }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $item['item_code'] ?? '' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $item['item_name'] ?? '' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $item['standard_rate'] ?? 0 }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $item['valuation_rate'] ?? 0 }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $item['last_purchase_rate'] ?? 0 }}
                            </td>

                            <td class="px-6 py-4 text-sm space-x-2">

                                <a href="{{ route('items.show', $item['name']) }}"
                                    class="bg-slate-600 hover:bg-slate-900 text-white py-1 px-3 rounded text-xs">
                                    View
                                </a>

                                <a href="{{ route('items.edit', $item['name']) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded text-xs">
                                    Edit
                                </a>

                                <form action="{{ route('items.destroy', $item['name']) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this item?')"
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
@endsection