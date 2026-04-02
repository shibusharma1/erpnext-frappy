@extends('layouts.app')
@section('title', isset($customer) ? 'Edit Customer' : 'Create Customer')

@section('contents')
    <div class="flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                {{ isset($customer) ? 'Edit' : 'Create' }} Customer
            </h2>

            <form method="POST"
                action="{{ isset($customer) ? route('customers.update', $customer['name']) : route('customers.store') }}">

                @csrf
                @if (isset($customer))
                    @method('PUT')
                @endif

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" name="customer_name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('customer_name', $customer['customer_name'] ?? '') }}">
                </div>

                {{-- <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <input type="text" name="country"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('country', $customer['country'] ?? '') }}">
                </div> --}}

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="text" name="mobile_no"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('mobile_no', $customer['mobile_no'] ?? '') }}" @readonly(isset($customer))>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('email_id', $customer['email_id'] ?? '') }}" @readonly(isset($customer))>
                </div>


                <button type="submit"
                    class="w-full bg-slate-900 hover:bg-slate-700 text-white font-medium py-2 rounded-lg transition duration-200">
                    Save
                </button>
            </form>
        </div>
    </div>
@endsection
