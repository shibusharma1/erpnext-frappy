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

            // Use 'nullable' or 'required_with' instead of the non-existent 'nullable_with'
            'items.*.item_code' => 'nullable|string',
            'items.*.qty' => 'nullable|numeric',
            'items.*.rate' => 'nullable|numeric',
            'items.*.amount' => 'nullable|numeric',

            'payment_schedule' => 'nullable|array',
            'payment_schedule.*.due_date' => 'nullable|date',
            'payment_schedule.*.payment_amount' => 'nullable|numeric',
        ];
    }
}
