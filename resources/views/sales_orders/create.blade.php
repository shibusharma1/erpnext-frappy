@extends('layouts.app')
@section('title', isset($salesOrder) ? 'Edit Sales Order' : 'Create Sales Order')

@section('contents')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-5xl bg-white rounded-lg shadow-md p-8">

            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                {{ isset($salesOrder) ? 'Edit' : 'Create' }} Sales Order
            </h2>

            {{-- Error Message --}}
            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-5">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST"
                action="{{ isset($salesOrder) ? route('sales.update', $salesOrder['name']) : route('sales.store') }}">
                @csrf
                @if (isset($salesOrder))
                    @method('PUT')
                @endif

                {{-- MAIN FORM --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Customer</label>
                        <input type="text" name="customer"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('customer', $salesOrder['customer'] ?? '') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Order Type</label>
                        <select name="order_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent">
                            <option value="Sales"
                                {{ old('order_type', $salesOrder['order_type'] ?? '') == 'Sales' ? 'selected' : '' }}>Sales
                            </option>
                            <option value="Maintenance"
                                {{ old('order_type', $salesOrder['order_type'] ?? '') == 'Maintenance' ? 'selected' : '' }}>
                                Maintenance</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Transaction Date</label>
                        <input type="date" name="transaction_date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('transaction_date', $salesOrder['transaction_date'] ?? '') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Date</label>
                        <input type="date" name="delivery_date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('delivery_date', $salesOrder['delivery_date'] ?? '') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                        <input type="text" name="currency"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('currency', $salesOrder['currency'] ?? 'NPR') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warehouse</label>
                        <input type="text" name="set_warehouse"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('set_warehouse', $salesOrder['set_warehouse'] ?? '') }}">
                    </div>

                </div>

                {{-- <div>
                    
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status
                        {{ $salesOrder['status'] ?? 'New' }}
                        {{ $salesOrder['docstatus'] ?? '0' }}
                    </label>
                    <select name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent">
                        @php
                            $currentStatus = old('status', $salesOrder['status'] ?? 'Draft');
                            $statuses = [
                                'Draft',
                                'On Hold',
                                'To Deliver and Bill',
                                'To Deliver',
                                'To Bill',
                                'Completed',
                                'Cancelled',
                                'Closed',
                            ];
                        @endphp

                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" {{ $currentStatus == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div> --}}

                {{-- ITEMS SECTION --}}
                <div class="mt-10">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-bold text-gray-800">Items</h3>

                        <button type="button" onclick="addItemRow()"
                            class="bg-slate-900 hover:bg-slate-700 text-white px-4 py-2 rounded-lg">
                            + Add Item
                        </button>
                    </div>

                    <div class="overflow-x-auto border rounded-lg">
                        <table class="w-full text-sm text-left text-gray-700">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3">Item Code</th>
                                    <th class="px-4 py-3">Qty</th>
                                    <th class="px-4 py-3">Rate</th>
                                    <th class="px-4 py-3">Action</th>
                                </tr>
                            </thead>

                            <tbody id="itemsTableBody">

                                {{-- If old input exists --}}
                                @php
                                    $items = old(
                                        'items',
                                        $salesOrder['items'] ?? [['item_code' => '', 'qty' => 1, 'rate' => 0]],
                                    );
                                @endphp

                                @foreach ($items as $index => $item)
                                    <tr class="border-t item-row">
                                        <td class="px-4 py-3">
                                            <input type="text" name="items[{{ $index }}][item_code]"
                                                class="w-full px-3 py-2 border rounded-lg"
                                                value="{{ $item['item_code'] ?? '' }}">
                                        </td>

                                        <td class="px-4 py-3">
                                            <input type="number" step="0.01" name="items[{{ $index }}][qty]"
                                                class="w-full px-3 py-2 border rounded-lg" value="{{ $item['qty'] ?? 1 }}">
                                        </td>

                                        <td class="px-4 py-3">
                                            <input type="number" step="0.01" name="items[{{ $index }}][rate]"
                                                class="w-full px-3 py-2 border rounded-lg"
                                                value="{{ $item['rate'] ?? 0 }}">
                                        </td>

                                        <td class="px-4 py-3">
                                            <button type="button" onclick="removeItemRow(this)"
                                                class="bg-red-600 hover:bg-red-500 text-white px-3 py-2 rounded-lg">
                                                Remove
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                    class="mt-8 w-full bg-slate-900 hover:bg-slate-700 text-white font-medium py-2 rounded-lg transition duration-200">
                    Save Sales Order
                </button>

            </form>
        </div>
    </div>

    {{-- JS --}}
    <script>
        let itemIndex = {{ count($items) }};

        function addItemRow() {
            const tbody = document.getElementById('itemsTableBody');

            const row = document.createElement('tr');
            row.classList.add('border-t', 'item-row');

            row.innerHTML = `
            <td class="px-4 py-3">
                <input type="text" name="items[${itemIndex}][item_code]"
                    class="w-full px-3 py-2 border rounded-lg" />
            </td>

            <td class="px-4 py-3">
                <input type="number" step="0.01" name="items[${itemIndex}][qty]"
                    class="w-full px-3 py-2 border rounded-lg" value="1" />
            </td>

            <td class="px-4 py-3">
                <input type="number" step="0.01" name="items[${itemIndex}][rate]"
                    class="w-full px-3 py-2 border rounded-lg" value="0" />
            </td>

            <td class="px-4 py-3">
                <button type="button" onclick="removeItemRow(this)"
                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-2 rounded-lg">
                    Remove
                </button>
            </td>
        `;

            tbody.appendChild(row);
            itemIndex++;
        }

        function removeItemRow(button) {
            button.closest('tr').remove();
        }
    </script>
@endsection
