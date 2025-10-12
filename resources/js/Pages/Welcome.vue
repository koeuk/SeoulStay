<script setup>
import { Head, Link } from '@inertiajs/vue3';
import NavigationBar from '@/Components/NavigationBar.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation Bar -->
        <NavigationBar />
        
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-br from-blue-600 to-purple-700 overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="text-center">
                    <img src="/seoul-station-logo.svg" alt="Seoul Stay" class="mx-auto h-20 w-auto mb-8">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                        Welcome to Seoul Stay
                    </h1>
                    <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                        Discover the perfect accommodation in Seoul. Whether you're traveling for business or pleasure, 
                        find your ideal stay in the heart of Korea's vibrant capital.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <template v-if="$page.props.auth.user">
                            <Link :href="route('dashboard')"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                                Go to Dashboard
                            </Link>
                        </template>
                        <template v-else>
                            <Link :href="route('register')"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                                Get Started
                            </Link>
                            <Link :href="route('login')"
                                class="inline-flex items-center px-6 py-3 border-2 border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                                Sign In
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Seoul Stay?</h2>
                    <p class="text-lg text-gray-600">Experience Seoul like never before with our curated accommodations</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Premium Properties</h3>
                        <p class="text-gray-600">Carefully selected accommodations in Seoul's best neighborhoods</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Prime Locations</h3>
                        <p class="text-gray-600">Stay close to Seoul's top attractions and business districts</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Trusted Service</h3>
                        <p class="text-gray-600">Reliable booking system with 24/7 customer support</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gray-100 py-16">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Explore Seoul?</h2>
                <p class="text-lg text-gray-600 mb-8">Join thousands of travelers who have discovered their perfect stay in Seoul</p>
                <template v-if="!$page.props.auth.user">
                    <Link :href="route('register')"
                        class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Start Your Journey
                    </Link>
                </template>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <img src="/seoul-station-logo.svg" alt="Seoul Stay" class="mx-auto h-12 w-auto mb-4">
                    <p class="text-gray-400">&copy; 2024 Seoul Stay. All rights reserved.</p>
                    <p class="text-sm text-gray-500 mt-2">Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})</p>
                </div>
            </div>
        </footer>
    </div>
</template>
