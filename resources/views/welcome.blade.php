@extends('layouts.app')
@section('title', 'Home')

@section('contents')
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-5xl font-bold text-gray-900 mb-6">Complete Enterprise Resource Planning</h1>
                <p class="text-xl text-gray-600 mb-8">Streamline your business operations with our comprehensive ERP solution
                    designed for modern enterprises.</p>
                <div class="flex gap-4">
                    <a href="https://cloud.frappe.io"
                        class="px-8 py-3 bg-slate-900 text-white rounded-lg hover:bg-slate-700 font-semibold">Get Started</a>
                    <a href="#"
                        class="px-8 py-3 border-2 border-slate-900 text-slate-900 rounded-lg hover:bg-blue-50 font-semibold">Learn
                        More</a>
                </div>
            </div>
            <div class="bg-gradient-to-br from-slate-600 to-slate-900 rounded-lg h-80 flex justify-center items-center">
                <img src="{{ asset('images/erp.png') }}" alt="ERP" class="max-h-72 w-auto">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-16">Core Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Analytics</h3>
                    <p class="text-gray-600">Real-time insights and comprehensive reporting for data-driven decisions.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">CRM</h3>
                    <p class="text-gray-600">Manage customer relationships and sales pipelines effortlessly.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-4">📦</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Inventory</h3>
                    <p class="text-gray-600">Complete supply chain and inventory management solutions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-slate-700 text-white py-16">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl font-bold mb-6">Ready to Transform Your Business?</h2>
            <p class="text-xl mb-8">Join thousands of companies using ERP Next.</p>
            <a href="/register" class="px-8 py-3 bg-white text-slate-900 rounded-lg hover:bg-gray-100 font-semibold">Start
                Free Trial</a>
        </div>
    </section>
@endsection
