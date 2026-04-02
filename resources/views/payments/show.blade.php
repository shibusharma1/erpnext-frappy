@extends('layouts.app')
@section('title', 'Payment Details')

@section('contents')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Payment Details</h2>

        <div class="space-y-4 mb-8">
            <div class="border-b border-gray-200 pb-4">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">ID</p>
                <p class="text-lg text-gray-900">{{ $payment['name'] }}</p>
            </div>
            <div class="border-b border-gray-200 pb-4">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Party</p>
                <p class="text-lg text-gray-900">{{ $payment['party'] }}</p>
            </div>
            <div class="border-b border-gray-200 pb-4">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Party Type</p>
                <p class="text-lg text-gray-900">{{ $payment['party_type'] }}</p>
            </div>
            <div class="border-b border-gray-200 pb-4">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Payment Type</p>
                <p class="text-lg text-gray-900">{{ $payment['payment_type'] }}</p>
            </div>
            <div class="border-b border-gray-200 pb-4">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Paid Amount</p>
                <p class="text-lg text-gray-900">{{ $payment['paid_amount'] }}</p>
            </div>
            <div class="border-b border-gray-200 pb-4">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Paid From</p>
                <p class="text-lg text-gray-900">{{ $payment['paid_from'] }}</p>
            </div>
            <div class="border-b border-gray-200 pb-4">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Paid To</p>
                <p class="text-lg text-gray-900">{{ $payment['paid_to'] }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Remarks</p>
                <p class="text-lg text-gray-900 whitespace-pre-line">{{ $payment['remarks'] ?? 'N/A' }}</p>
            </div>
        </div>

        <a href="{{ route('payments.index') }}"
            class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
            ← Back to Payments
        </a>
    </div>
</div>
@endsection 