@if (session('success') || session('error') || $errors->any())
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        
        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-4 flex items-start gap-3 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-800 shadow-sm">
                <svg class="h-5 w-5 mt-0.5 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <div class="text-sm font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
            <div class="mb-4 flex items-start gap-3 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-red-800 shadow-sm">
                <svg class="h-5 w-5 mt-0.5 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <div class="text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-red-800 shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="h-5 w-5 mt-0.5 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <div>
                        <p class="font-semibold text-sm mb-1">Please fix the following errors:</p>

                        <ul class="list-disc pl-5 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endif