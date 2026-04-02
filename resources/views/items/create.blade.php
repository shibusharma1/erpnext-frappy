@extends('layouts.app')
@section('title', isset($item) ? 'Edit Item' : 'Create Item')

@section('contents')
    <div class="min-h-screen flex items-center justify-center py-10 px-4">
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8">

            <h2 class="text-2xl font-bold mb-6">
                {{ isset($item) ? 'Edit' : 'Create' }} Item
            </h2>

            <form method="POST" action="{{ isset($item) ? route('items.update', $item['name']) : route('items.store') }}">

                @csrf
                @if (isset($item))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-2 gap-4">

                    {{-- BASIC --}}
                    <div>
                        <label class="text-sm">Item Code</label>
                        <input type="text" name="item_code" class="w-full border p-2 rounded"
                            value="{{ old('item_code', $item['item_code'] ?? '') }}">
                    </div>

                    <div>
                        <label>Item Name</label>
                        <input type="text" name="item_name" class="w-full border p-2 rounded"
                            value="{{ old('item_name', $item['item_name'] ?? '') }}">
                    </div>

                    <div>
                        <label>Item Group</label>
                        <input type="text" name="item_group" class="w-full border p-2 rounded"
                            value="{{ old('item_group', $item['item_group'] ?? '') }}">
                    </div>

                    <div>
                        <label>Stock UOM</label>
                        <input type="text" name="stock_uom" class="w-full border p-2 rounded"
                            value="{{ old('stock_uom', $item['stock_uom'] ?? 'Nos') }}">
                    </div>

                    <div>
                        <label>Brand</label>
                        <input type="text" name="brand" class="w-full border p-2 rounded"
                            value="{{ old('brand', $item['brand'] ?? '') }}">
                    </div>

                    <div>
                        <label>Country of Origin</label>
                        <input type="text" name="country_of_origin" class="w-full border p-2 rounded"
                            value="{{ old('country_of_origin', $item['country_of_origin'] ?? 'Nepal') }}">
                    </div>

                    {{-- NUMERIC --}}
                    <div>
                        <label>Standard Rate</label>
                        <input type="number" step="0.01" name="standard_rate" class="w-full border p-2 rounded"
                            value="{{ old('standard_rate', $item['standard_rate'] ?? 0) }}">
                    </div>

                    <div>
                        <label>Valuation Rate</label>
                        <input type="number" step="0.01" name="valuation_rate" class="w-full border p-2 rounded"
                            value="{{ old('valuation_rate', $item['valuation_rate'] ?? 0) }}">
                    </div>

                    <div>
                        <label>Opening Stock</label>
                        <input type="number" name="opening_stock" class="w-full border p-2 rounded"
                            value="{{ old('opening_stock', $item['opening_stock'] ?? 0) }}">
                    </div>

                    <div>
                        <label>Weight Per Unit</label>
                        <input type="number" name="weight_per_unit" class="w-full border p-2 rounded"
                            value="{{ old('weight_per_unit', $item['weight_per_unit'] ?? 0) }}">
                    </div>

                    <div>
                        <label>Shelf Life (Days)</label>
                        <input type="number" name="shelf_life_in_days" class="w-full border p-2 rounded"
                            value="{{ old('shelf_life_in_days', $item['shelf_life_in_days'] ?? 0) }}">
                    </div>

                    <div>
                        <label>End of Life</label>
                        <input type="date" name="end_of_life" class="w-full border p-2 rounded"
                            value="{{ old('end_of_life', $item['end_of_life'] ?? '') }}">
                    </div>

                    {{-- PURCHASE --}}
                    <div>
                        <label>Min Order Qty</label>
                        <input type="number" name="min_order_qty" class="w-full border p-2 rounded"
                            value="{{ old('min_order_qty', $item['min_order_qty'] ?? 0) }}">
                    </div>

                    <div>
                        <label>Lead Time (Days)</label>
                        <input type="number" name="lead_time_days" class="w-full border p-2 rounded"
                            value="{{ old('lead_time_days', $item['lead_time_days'] ?? 0) }}">
                    </div>

                    <div>
                        <label>Last Purchase Rate</label>
                        <input type="number" name="last_purchase_rate" class="w-full border p-2 rounded"
                            value="{{ old('last_purchase_rate', $item['last_purchase_rate'] ?? 0) }}">
                    </div>

                    <div>
                        <label>Max Discount</label>
                        <input type="number" name="max_discount" class="w-full border p-2 rounded"
                            value="{{ old('max_discount', $item['max_discount'] ?? 0) }}">
                    </div>

                    <div class="col-span-2">
                        <label>Description</label>
                        <textarea name="description" class="w-full border p-2 rounded">{{ old('description', $item['description'] ?? '') }}</textarea>
                    </div>

                </div>

                {{-- CHECKBOXES --}}
                <div class="grid grid-cols-3 gap-3 mt-6 text-sm">

                    <label><input type="checkbox" name="is_stock_item" value="1"
                            {{ old('is_stock_item', $item['is_stock_item'] ?? 0) ? 'checked' : '' }}> Stock
                        Item</label>

                    <label><input type="checkbox" name="is_sales_item" value="1"
                            {{ old('is_sales_item', $item['is_sales_item'] ?? 0) ? 'checked' : '' }}> Sales
                        Item</label>

                    <label><input type="checkbox" name="is_purchase_item" value="1"
                            {{ old('is_purchase_item', $item['is_purchase_item'] ?? 0) ? 'checked' : '' }}> Purchase
                        Item</label>

                    <label><input type="checkbox" name="has_batch_no" value="1"
                            {{ old('has_batch_no', $item['has_batch_no'] ?? 0) ? 'checked' : '' }}> Batch No</label>

                    <label><input type="checkbox" name="has_serial_no" value="1"
                            {{ old('has_serial_no', $item['has_serial_no'] ?? 0) ? 'checked' : '' }}> Serial No</label>

                    <label><input type="checkbox" name="allow_negative_stock" value="1"
                            {{ old('allow_negative_stock', $item['allow_negative_stock'] ?? 0) ? 'checked' : '' }}>
                        Allow Negative Stock</label>

                    <label><input type="checkbox" name="include_item_in_manufacturing" value="1"
                            {{ old('include_item_in_manufacturing', $item['include_item_in_manufacturing'] ?? 0) ? 'checked' : '' }}>
                        Manufacturing</label>

                    <label><input type="checkbox" name="grant_commission" value="1"
                            {{ old('grant_commission', $item['grant_commission'] ?? 0) ? 'checked' : '' }}>
                        Commission</label>

                    <label><input type="checkbox" name="disabled" value="1"
                            {{ old('disabled', $item['disabled'] ?? 0) ? 'checked' : '' }}> Disabled</label>

                </div>

                <button class="w-full mt-6 bg-slate-900 text-white py-2 rounded">
                    Save Item
                </button>

            </form>
        </div>
    </div>
@endsection
