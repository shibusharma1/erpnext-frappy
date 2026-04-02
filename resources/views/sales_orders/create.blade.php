@extends('layouts.app')
@section('title', isset($salesOrder) ? 'Edit Sales Order' : 'Create Sales Order')

@section('contents')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-3xl bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            {{ isset($salesOrder) ? 'Edit' : 'Create' }} Sales Order
        </h2>

        <form method="POST"
            action="{{ isset($salesOrder) ? route('sales.update', $salesOrder['name']) : route('sales.store') }}">
            @csrf
            @if(isset($salesOrder))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Customer -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Customer</label>
                    <input type="text" name="customer"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('customer', $salesOrder['customer'] ?? '') }}">
                </div>

                <!-- Order Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Order Type</label>
                    <select name="order_type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent">
                        <option value="Sales" {{ (old('order_type', $salesOrder['order_type'] ?? '') == 'Sales') ? 'selected' : '' }}>Sales</option>
                        <option value="Maintenance" {{ (old('order_type', $salesOrder['order_type'] ?? '') == 'Maintenance') ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                <!-- Transaction Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Transaction Date</label>
                    <input type="date" name="transaction_date"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('transaction_date', $salesOrder['transaction_date'] ?? '') }}">
                </div>

                <!-- Delivery Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Date</label>
                    <input type="date" name="delivery_date"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('delivery_date', $salesOrder['delivery_date'] ?? '') }}">
                </div>

                <!-- Total Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Quantity</label>
                    <input type="number" name="total_qty"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('total_qty', $salesOrder['total_qty'] ?? 0) }}">
                </div>

                <!-- Total Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Amount</label>
                    <input type="number" name="total"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('total', $salesOrder['total'] ?? 0) }}">
                </div>

                <!-- Currency -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                    <input type="text" name="currency"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('currency', $salesOrder['currency'] ?? 'NPR') }}">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent">
                        <option value="Draft" {{ (old('status', $salesOrder['status'] ?? '') == 'Draft') ? 'selected' : '' }}>Draft</option>
                        <option value="Completed" {{ (old('status', $salesOrder['status'] ?? '') == 'Completed') ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

            </div>

            <button type="submit"
                class="mt-6 w-full bg-slate-900 hover:bg-slate-700 text-white font-medium py-2 rounded-lg transition duration-200">
                Save
            </button>
        </form>
    </div>
</div>
@endsection