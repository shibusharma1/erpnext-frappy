@extends('layouts.app')
@section('title', 'ERPNext Integration Docs')

@section('contents')
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-5xl font-bold text-gray-900 mb-6">ERPNext Integration with Laravel</h1>
                <p class="text-xl text-gray-600 mb-8">
                    Seamlessly connect your Laravel applications with ERPNext using our robust REST API integration framework.
                    Manage your business data, automate workflows, and leverage ERP capabilities directly from your Laravel backend.
                </p>
                <div class="flex gap-4">
                    <a href="https://github.com/alyf-de/frappe_api-docs"
                        class="px-8 py-3 bg-slate-900 text-white rounded-lg hover:bg-slate-700 font-semibold" target="_blank">View API Docs</a>
                    <a href="https://docs.frappe.io/framework/user/en/guides/integration/rest_api"
                        class="px-8 py-3 border-2 border-slate-900 text-slate-900 rounded-lg hover:bg-blue-50 font-semibold" target="_blank">Frappe REST API Guide</a>
                </div>
            </div>
            <div class="bg-gradient-to-br from-slate-600 to-slate-900 rounded-lg h-80 flex justify-center items-center">
                <img src="{{ asset('images/erp.png') }}" alt="ERPNext Integration" class="max-h-72 w-auto">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-16">Key Integration Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🔗</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">API-First Approach</h3>
                    <p class="text-gray-600">
                        Use ERPNext's RESTful APIs to create, read, update, and delete records programmatically with Laravel.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Automation</h3>
                    <p class="text-gray-600">
                        Automate ERP workflows like invoicing, stock updates, and HR processes directly from your Laravel backend.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Real-time Data Sync</h3>
                    <p class="text-gray-600">
                        Keep your Laravel app in sync with ERPNext records to ensure data consistency across platforms.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Integrate Section -->
    <section id="integration" class="py-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-gray-900 mb-12 text-center">Step-by-Step Integration</h2>

            <div class="space-y-12">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">1. Setup ERPNext API Access</h3>
                    <p class="text-gray-600 mb-4">
                        Generate an API key and secret in ERPNext for authentication. Ensure you have the required permissions for the resources you want to access.
                    </p>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto">
ERPNEXT_CLIENT_ID=your_client_id
ERPNEXT_CLIENT_SECRET=your_client_secret
                    </pre>
                </div>

                <div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">2. Install Laravel Frappe Integration Package</h3>
                    <p class="text-gray-600 mb-4">
                        Use a composer package like <code>alyf-de/frappe-api</code> or create custom HTTP clients for API requests.
                    </p>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto">
composer require alyf-de/frappe-api
                    </pre>
                </div>

                <div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">3. Configure Environment</h3>
                    <p class="text-gray-600 mb-4">
                        Add the ERPNext API base URL, client ID, and secret to your <code>.env</code> file.
                    </p>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto">
FRAPPE_API_URL=https://your-erpnext-site.com
FRAPPE_API_KEY=your_api_key
FRAPPE_API_SECRET=your_api_secret
                    </pre>
                </div>

                <div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">4. Making API Calls</h3>
                    <p class="text-gray-600 mb-4">
                        Use Laravel's <code>Http::withToken(...)</code> for authenticated API requests.
                    </p>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto">
use Illuminate\Support\Facades\Http;

$response = Http::withToken(env('FRAPPE_API_KEY'))
    ->get(env('FRAPPE_API_URL').'/api/resource/Item');

$data = $response->json();
                    </pre>
                </div>

                <div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">5. Handling Common Doctypes</h3>
                    <p class="text-gray-600 mb-4">
                        ERPNext provides standard doctypes like Customers, Items, Sales Invoices, and Stock Entries. Use the API to manage these entities directly.
                    </p>
                    <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto">
GET /api/resource/Customer
POST /api/resource/Item
PUT /api/resource/Sales Invoice/{name}
DELETE /api/resource/Stock Entry/{name}
                    </pre>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-slate-700 text-white py-16">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl font-bold mb-6">Ready to Integrate ERPNext with Laravel?</h2>
            <p class="text-xl mb-8">Start automating your enterprise workflows today.</p>
            <a href="https://cloud.frappe.io" class="px-8 py-3 bg-white text-slate-900 rounded-lg hover:bg-gray-100 font-semibold"  target="_blank">Get Started</a>
        </div>
    </section>
@endsection 