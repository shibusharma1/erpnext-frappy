<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer' => 'nullable|string|max:255',
            'customer_name' => 'nullable|string|max:255',
            'order_type' => 'nullable|string|max:50',
            'transaction_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'currency' => 'nullable|string|max:10',
            'total_qty' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'grand_total' => 'nullable|numeric',
            'set_warehouse' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.item_code' => 'nullable_with:items|string',
            'items.*.qty' => 'nullable_with:items|numeric',
            'items.*.rate' => 'nullable_with:items|numeric',
            'items.*.amount' => 'nullable_with:items|numeric',
            'payment_schedule' => 'nullable|array',
            'payment_schedule.*.due_date' => 'nullable_with:payment_schedule|date',
            'payment_schedule.*.payment_amount' => 'nullable_with:payment_schedule|numeric',
        ];
    }
}