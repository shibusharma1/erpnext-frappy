<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_type' => 'nullable|string',
            'posting_date' => 'nullable|date',
            'party_type' => 'nullable|string',
            'party' => 'nullable|string',
            'paid_from' => 'nullable|string',
            'paid_to' => 'nullable|string',
            'paid_amount' => 'nullable|numeric',
            'received_amount' => 'nullable|numeric',
            'reference_no' => 'nullable|string',
            'remarks' => 'nullable|string',
            'docstatus' => 'nullable|string',
        ];
    }
}