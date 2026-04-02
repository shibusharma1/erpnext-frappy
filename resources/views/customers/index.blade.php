@extends('layouts.app')
@section('title', 'Customers')

@section('contents')
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Customers</h2>
            <a href="{{ route('customers.create') }}"
                class="bg-slate-900 hover:bg-slate-700 text-white font-semibold py-2 px-4 rounded">
                Add Customer
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Country</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Phone</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $customer['name'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $customer['customer_name'] ?? '' }}</td>
                            {{-- <td class="px-6 py-4 text-sm text-gray-900">{{ $customer['customer_primary_address'] ?? '' }}</td> --}}
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{-- {{ strip_tags($customer['primary_address'] ?? '') }} --}}
                                {{-- {{ trim(collect(explode('<br>', $customer['primary_address'] ?? ''))->filter()->last()) ?? 'N/A' }} --}}
                                {{ trim(
                                    collect(explode('<br>', $customer['primary_address'] ?? ''))->filter()->values()->slice(-3, 1)->first(),
                                ) ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $customer['mobile_no'] ?? '' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $customer['email_id'] ?? '' }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('customers.show', $customer['name']) }}"
                                    class="bg-slate-600 hover:bg-slate-900 text-white py-1 px-3 rounded text-xs">View</a>
                                <a href="{{ route('customers.edit', $customer['name']) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded text-xs">Edit</a>

                                <form action="{{ route('customers.destroy', $customer['name']) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this customer?')"
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
