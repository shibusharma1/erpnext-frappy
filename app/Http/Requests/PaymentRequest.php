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
            'payment_type' => 'required|string',
            'posting_date' => 'required|date',
            'party_type' => 'required|string',
            'party' => 'required|string',
            'paid_from' => 'required|string',
            'paid_to' => 'required|string',
            'paid_amount' => 'required|numeric',
            'reference_no' => 'nullable|string',
            'remarks' => 'nullable|string',
        ];
    }
}