@extends('layouts.app')
@section('title', 'Payments')

@section('contents')
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Payments</h2>
            <a href="{{ route('payments.create') }}"
                class="bg-slate-900 hover:bg-slate-700 text-white font-semibold py-2 px-4 rounded">
                Add Payment
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-200 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Payment Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Party</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Party Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Paid Amount</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $payment['name'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $payment['payment_type'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $payment['party'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $payment['party_type'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $payment['paid_amount'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $payment['status'] ?? 'N/A' }}</td>

                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('payments.show', $payment['name']) }}"
                                    class="bg-slate-600 hover:bg-slate-900 text-white py-1 px-3 rounded text-xs">
                                    View
                                </a>

                                <a href="{{ route('payments.edit', $payment['name']) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded text-xs">
                                    Edit
                                </a>

                                <form action="{{ route('payments.destroy', $payment['name']) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this payment?')"
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if (count($payments) == 0)
                        <tr>
                            <td colspan="7" class="text-center px-6 py-6 text-gray-500">
                                No payments found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection