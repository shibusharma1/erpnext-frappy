@extends('layouts.app')
@section('title', 'Sales Order Details')

@section('contents')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Sales Order Details</h2>

        {{-- General Details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @foreach ($salesOrder as $key => $value)
                @if (!is_array($value))
                    <div class="border-b border-gray-200 pb-4">
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ str_replace('_', ' ', $key) }}</p>
                        <p class="text-lg text-gray-900">{{ $value ?? 'N/A' }}</p>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Items Table --}}
        @if (!empty($salesOrder['items']))
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Items</h3>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Item Code</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Item Name</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Description</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Qty</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Rate</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Amount</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Warehouse</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salesOrder['items'] as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b text-sm">{{ $item['item_code'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b text-sm">{{ $item['item_name'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b text-sm">{{ $item['description'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b text-sm">{{ $item['qty'] ?? 0 }}</td>
                        <td class="px-4 py-2 border-b text-sm">{{ $item['rate'] ?? 0 }}</td>
                        <td class="px-4 py-2 border-b text-sm">{{ $item['amount'] ?? 0 }}</td>
                        <td class="px-4 py-2 border-b text-sm">{{ $item['warehouse'] ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Payment Schedule Table --}}
        @if (!empty($salesOrder['payment_schedule']))
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Payment Schedule</h3>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Due Date</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Invoice Portion (%)</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Payment Amount</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Outstanding</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold">Paid Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salesOrder['payment_schedule'] as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b text-sm">{{ $payment['due_date'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b text-sm">{{ $payment['invoice_portion'] ?? 0 }}</td>
                        <td class="px-4 py-2 border-b text-sm">{{ $payment['payment_amount'] ?? 0 }}</td>
                        <td class="px-4 py-2 border-b text-sm">{{ $payment['outstanding'] ?? 0 }}</td>
                        <td class="px-4 py-2 border-b text-sm">{{ $payment['paid_amount'] ?? 0 }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <a href="{{ route('sales.index') }}"
            class="mt-6 inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
            ← Back to Sales Orders
        </a>
    </div>
</div>
@endsection