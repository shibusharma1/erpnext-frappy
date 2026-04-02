@extends('layouts.app')
@section('title', 'Item Details')

@section('contents')
    <div class="min-h-screen flex items-center justify-center py-10 px-4">
        <div class="w-full max-w-3xl bg-white rounded-lg shadow-lg p-8">

            <h2 class="text-3xl font-bold mb-6">Item Details</h2>

            <div class="grid grid-cols-2 gap-4 text-sm">

                <div><strong>Code:</strong> {{ $item['item_code'] }}</div>
                <div><strong>Name:</strong> {{ $item['item_name'] }}</div>
                <div><strong>Group:</strong> {{ $item['item_group'] }}</div>
                <div><strong>UOM:</strong> {{ $item['stock_uom'] }}</div>

                <div><strong>Brand:</strong> {{ $item['brand'] ?? 'N/A' }}</div>
                <div><strong>Country:</strong> {{ $item['country_of_origin'] ?? 'N/A' }}</div>

                <div><strong>Standard Rate:</strong> {{ $item['standard_rate'] }}</div>
                <div><strong>Valuation Rate:</strong> {{ $item['valuation_rate'] }}</div>

                <div><strong>Opening Stock:</strong> {{ $item['opening_stock'] }}</div>
                <div><strong>Weight:</strong> {{ $item['weight_per_unit'] }}</div>

                <div><strong>Shelf Life:</strong> {{ $item['shelf_life_in_days'] }}</div>
                <div><strong>End of Life:</strong> {{ $item['end_of_life'] }}</div>

                <div><strong>Min Order Qty:</strong> {{ $item['min_order_qty'] }}</div>
                <div><strong>Lead Time:</strong> {{ $item['lead_time_days'] }}</div>

                <div><strong>Last Purchase Rate:</strong> {{ $item['last_purchase_rate'] }}</div>
                <div><strong>Max Discount:</strong> {{ $item['max_discount'] }}</div>

                <div><strong>Stock Item:</strong> {{ $item['is_stock_item'] ? 'Yes' : 'No' }}</div>
                <div><strong>Sales Item:</strong> {{ $item['is_sales_item'] ? 'Yes' : 'No' }}</div>

                <div><strong>Purchase Item:</strong> {{ $item['is_purchase_item'] ? 'Yes' : 'No' }}</div>
                <div><strong>Disabled:</strong> {{ $item['disabled'] ? 'Yes' : 'No' }}</div>

                <div class="col-span-2">
                    <strong>Description:</strong>
                    <p>{{ $item['description'] ?? 'N/A' }}</p>
                </div>

            </div>

            <a href="{{ route('items.index') }}" class="mt-6 inline-block bg-gray-700 text-white px-4 py-2 rounded">
                ← Back
            </a>

        </div>
    </div>
@endsection
