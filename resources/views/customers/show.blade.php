@extends('layouts.app')
@section('title', 'Customer Details')

@section('contents')
    <div class="flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Customer Details</h2>

            <div class="space-y-4 mb-8">
                <div class="border-b border-gray-200 pb-4">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">ID</p>
                    <p class="text-lg text-gray-900">{{ $customer['name'] }}</p>
                </div>
                <div class="border-b border-gray-200 pb-4">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Name</p>
                    <p class="text-lg text-gray-900">{{ $customer['customer_name'] }}</p>
                </div>
                {{-- <div class="border-b border-gray-200 pb-4">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Country</p>
                    <p class="text-lg text-gray-900">{{ $customer['country'] ?? 'N/A' }}</p>
                </div> --}}
                <div class="border-b border-gray-200 pb-4">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Phone</p>
                    <p class="text-lg text-gray-900">{{ $customer['mobile_no'] ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Email</p>
                    <p class="text-lg text-gray-900">{{ $customer['email_id'] ?? 'N/A' }}</p>
                </div>
            </div>

            <a href="{{ route('customers.index') }}"
                class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                ← Back to Customers
            </a>
        </div>
    </div>
@endsection
