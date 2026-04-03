@extends('layouts.app')
@section('title', isset($payment) ? 'Edit Payment' : 'Create Payment')

@section('contents')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-6">
        <div class="w-full max-w-3xl bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                {{ isset($payment) ? 'Edit' : 'Create' }} Payment
            </h2>

            <form method="POST"
                action="{{ isset($payment) ? route('payments.update', $payment['name']) : route('payments.store') }}">

                @csrf
                @if (isset($payment))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Party Name</label>
                        <input type="text" name="party"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('party', $payment['party'] ?? '') }}">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Amount</label>
                        <input type="number" name="paid_amount" step="0.01"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('paid_amount', $payment['paid_amount'] ?? '') }}">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Received Amount</label>
                        <input type="number" name="received_amount" step="0.01"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('received_amount', $payment['received_amount'] ?? '') }}">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Received Date(May be)</label>
                        <input type="date" name="posting_date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('posting_date', $payment['posting_date'] ?? '') }}">
                    </div>


                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Party Type</label>
                        <input type="text" name="party_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('party_type', $payment['party_type'] ?? '') }}">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Type(Receive, Pay and Internal
                            Transfer)</label>
                        <input type="text" name="payment_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('payment_type', $payment['payment_type'] ?? '') }}">
                    </div>


                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Paid From</label>
                        <input type="text" name="paid_from"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                            value="{{ old('paid_from', $payment['paid_from'] ?? '') }}">
                    </div>

                    {{-- <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Paid To</label>
                    <input type="text" name="paid_to"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('paid_to', $payment['paid_to'] ?? '') }}">
                </div>


                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reference No</label>
                    <input type="text" name="reference_no"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        value="{{ old('reference_no', $payment['reference_no'] ?? '') }}">
                </div> --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="docstatus"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent">

                            <option value="0"
                                {{ old('docstatus', $payment['docstatus'] ?? 0) == 0 ? 'selected' : '' }}>
                                Draft
                            </option>

                            <option value="1"
                                {{ old('docstatus', $payment['docstatus'] ?? 0) == 1 ? 'selected' : '' }}>
                                Submitted
                            </option>
                            {{-- @if (isset($payment['docstatus']) && $payment['docstatus'] == 1) --}}
                            <option value="2"
                                {{ old('docstatus', $payment['docstatus'] ?? 0) == 2 ? 'selected' : '' }}>
                                Cancelled
                            </option>
                            {{-- @endif --}}

                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Note</label>
                    <textarea name="remarks"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-600 focus:border-transparent"
                        rows="3">{{ old('remarks', $payment['remarks'] ?? '') }}</textarea>
                </div>

                <button type="submit"
                    class="w-full bg-slate-900 hover:bg-slate-700 text-white font-medium py-2 rounded-lg transition duration-200">
                    Save
                </button>

            </form>
        </div>
    </div>
@endsection

{{-- 
⚠️ Important Notes
1. If payment_type is Receive

You must send:

received_amount
paid_to 
2. If payment_type is Pay

You must send:

paid_amount
paid_from --}}
