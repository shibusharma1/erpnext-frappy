@extends('layouts.app')
@section('title', 'Sales Orders')

@section('contents')
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Sales Orders</h2>
            <a href="{{ route('sales.create') }}"
                class="bg-slate-900 hover:bg-slate-700 text-white font-semibold py-2 px-4 rounded">
                Add Sales Order
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Order Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total Qty</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total Amount</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales_orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $order['name'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $order['customer_name'] ?? ($order['customer'] ?? 'N/A') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $order['order_type'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $order['total_qty'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $order['total'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('sales.show', $order['name']) }}"
                                    class="bg-slate-600 hover:bg-slate-900 text-white py-1 px-3 rounded text-xs">View</a>
                                <a href="{{ route('sales.edit', $order['name']) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded text-xs">Edit</a>

                                <form action="{{ route('sales.destroy', $order['name']) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this sales order?')"
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if (count($sales_orders) === 0)
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No Sales Orders found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
