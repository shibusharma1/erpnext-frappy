<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 pt-12 pb-6 mt-1">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Top Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 border-b border-gray-700 pb-10">

            <!-- Company Info -->
            <div>
                <h2 class="text-xl font-semibold text-white">ERP Next</h2>
                <p class="mt-3 text-gray-400 text-sm leading-relaxed text-justify">
                    ERP Next Frappy is a modern ERP solution designed to simplify and automate your business operations.
                    It helps you manage inventory, sales, purchases, accounting, HR, and customer relationships
                    efficiently
                    through a clean and user-friendly system, making your workflow faster, smarter, and more organized.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-white">Quick Links</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="{{ url('/') }}" class="hover:text-white transition">Home</a></li>
                    <li><a href="{{ url('/items') }}" class="hover:text-white transition">Item</a></li>
                    <li><a href="{{ url('/customers') }}" class="hover:text-white transition">Customers</a></li>
                    <li><a href="{{ url('/sales') }}" class="hover:text-white transition">Sales Order</a></li>
                    <li><a href="{{ url('/payments') }}" class="hover:text-white transition">Payment Entry</a></li>
                </ul>
            </div>

            <!-- Contact & Social -->
            <div>
                <h3 class="text-lg font-semibold text-white">Connect</h3>
                <p class="mt-4 text-sm text-gray-400">
                    Email:
                    <a href="mailto:shibusharma807@gmail.com" class="hover:text-white transition">
                        shibusharma807@gmail.com
                    </a>
                </p>

                <p class="text-sm text-gray-400">
                    Phone:
                    <a href="tel:+9779819099126" class="hover:text-white transition">
                        +977 9819099126
                    </a>
                </p>

                <!-- Social Icons -->
                <div class="flex gap-4 mt-5 justify-start">
                    <a href="https://www.facebook.com/shibu.sharma.5015983" class="hover:text-white transition"
                        target="_blank">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2V12h2.3l-.4 3h-1.9v7A10 10 0 0 0 22 12" />
                        </svg>
                    </a>

                    <a href="www.linkedin.com/in/shibusharma" class="hover:text-white transition" target="_blank">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.45 20.45h-3.55v-5.4c0-1.29-.03-2.95-1.8-2.95-1.8 0-2.08 1.4-2.08 2.85v5.5H9.47V9h3.4v1.56h.05c.47-.9 1.63-1.85 3.35-1.85 3.58 0 4.24 2.36 4.24 5.43v6.31zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9h3.56v11.45z" />
                        </svg>
                    </a>

                    <a href="https://github.com/shibusharma1" class="hover:text-white transition" target="_blank">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.2c-5.4 0-9.8 4.4-9.8 9.8 0 4.3 2.8 8 6.7 9.3.5.1.7-.2.7-.5v-1.7c-2.7.6-3.3-1.1-3.3-1.1-.4-1-.9-1.3-.9-1.3-.7-.5.1-.5.1-.5.8.1 1.2.8 1.2.8.7 1.2 1.9.9 2.4.7.1-.5.3-.9.5-1.1-2.2-.2-4.4-1.1-4.4-4.9 0-1.1.4-2 .9-2.7-.1-.2-.4-1.3.1-2.7 0 0 .8-.3 2.8 1a9.6 9.6 0 0 1 5.1 0c2-1.3 2.8-1 2.8-1 .5 1.4.2 2.5.1 2.7.6.7.9 1.6.9 2.7 0 3.8-2.3 4.7-4.5 4.9.3.3.6.9.6 1.8v2.6c0 .3.2.6.7.5 3.9-1.3 6.7-5 6.7-9.3 0-5.4-4.4-9.8-9.8-9.8z" />
                        </svg>
                    </a>

                    </a>

                    <a href="https://shibusharma.com.np/" target="_blank" class="hover:text-white transition"
                        aria-label="Website">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- Bottom Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mt-6 text-sm text-gray-500">
            <p>&copy;{{ date('Y') }} ERP Next. All rights reserved.</p>

            <p class="mt-3 md:mt-0">
                Designed & Developed by
                <span class="text-white font-semibold">Shibu Sharma</span>
            </p>
        </div>

    </div>
</footer>
