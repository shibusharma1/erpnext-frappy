<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_code' => 'nullable|string|max:50',
            'item_name' => 'nullable|string|max:255',
            'item_group' => 'nullable|string|max:255',
            'stock_uom' => 'nullable|string|max:50',

            'brand' => 'nullable|string|max:255',
            'country_of_origin' => 'nullable|string|max:100',

            'standard_rate' => 'nullable|numeric',
            'valuation_rate' => 'nullable|numeric',
            'opening_stock' => 'nullable|numeric',

            'weight_per_unit' => 'nullable|numeric',
            'shelf_life_in_days' => 'nullable|integer',
            'end_of_life' => 'nullable|date',

            'min_order_qty' => 'nullable|numeric',
            'lead_time_days' => 'nullable|integer',
            'last_purchase_rate' => 'nullable|numeric',
            'max_discount' => 'nullable|numeric',

            'description' => 'nullable|string',

            // BOOLEAN FLAGS
            'is_stock_item' => 'nullable|boolean',
            'is_sales_item' => 'nullable|boolean',
            'is_purchase_item' => 'nullable|boolean',
            'has_batch_no' => 'nullable|boolean',
            'has_serial_no' => 'nullable|boolean',
            'allow_negative_stock' => 'nullable|boolean',
            'include_item_in_manufacturing' => 'nullable|boolean',
            'grant_commission' => 'nullable|boolean',
            'disabled' => 'nullable|boolean',
        ];
    }
}