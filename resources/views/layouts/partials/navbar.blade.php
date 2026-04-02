    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    {{-- <svg class="w-8 h-8 text-slate-900" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                        <path d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"></path>
                        <path d="M14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg> --}}
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('logo/frappy.png') }}" alt="Frappy" class="h-10 w-auto">
                    </a>
                    <span class="text-xl font-bold text-gray-900">ERP Next | Frappy</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-slate-900">Home</a>
                    <a href="#features" class="text-gray-700 hover:text-slate-900">Features</a>
                    <a href="https://frappe.io/cloud/pricing" class="text-gray-700 hover:text-slate-900" target="blank">Pricing</a>
                    <a href="{{ url('/docs') }}" class="text-gray-700 hover:text-slate-900">Docs</a>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('erpnext.auth') }}"
                        class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-700">Connect</a>
                </div>
            </div>
        </div>
    </nav>
