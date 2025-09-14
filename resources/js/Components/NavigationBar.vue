<template>
    <nav class="bg-gray-900 border-b-4 border-black shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo Section -->
                <div class="flex items-center">
                    <Link  class="flex items-center">
                    <div
                        class=" text-white  px-4 py-2 rounded font-bold text-lg ">
                        Seoul Stay
                    </div>
                    </Link>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:block">
                    <div class="flex items-center space-x-4">

                        <template v-if="$page.props.auth.user">
                            <Link :href="route('dashboard')"
                                class="text-white hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                :class="{ 'text-purple-400 bg-gray-800': $page.url.startsWith('/dashboard') }">
                            Dashboard
                            </Link>

                            <div class="relative group">
                                <button
                                    class="text-white hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                    {{ $page.props.auth.user.name || $page.props.auth.user.username }}
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <div
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border-2 border-gray-300">
                                    <Link :href="route('profile.edit')"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Profile Settings
                                    </Link>
                                    <Link :href="route('logout')" method="post" as="button"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign Out
                                    </Link>
                                </div>
                            </div>
                        </template>

                        <template v-else>
                            <Link :href="route('login')"
                                class="text-white hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                :class="{ 'text-purple-400 bg-gray-800': $page.url === '/login' }">
                            Login
                            </Link>

                            <Link :href="route('register')"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors border-2 border-purple-500">
                            Register
                            </Link>
                        </template>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-white hover:text-purple-400 p-2 rounded-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div v-show="mobileMenuOpen" class="md:hidden bg-gray-800 border-t border-gray-700">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <Link :href="route('home')"
                    class="text-white hover:text-purple-400 block px-3 py-2 rounded-md text-base font-medium"
                    @click="mobileMenuOpen = false">
                Main Page
                </Link>

                <template v-if="$page.props.auth.user">
                    <Link :href="route('dashboard')"
                        class="text-white hover:text-purple-400 block px-3 py-2 rounded-md text-base font-medium"
                        @click="mobileMenuOpen = false">
                    Dashboard
                    </Link>

                    <Link :href="route('items.index')"
                        class="text-white hover:text-purple-400 block px-3 py-2 rounded-md text-base font-medium"
                        @click="mobileMenuOpen = false">
                    Properties
                    </Link>

                    <Link :href="route('profile.edit')"
                        class="text-white hover:text-purple-400 block px-3 py-2 rounded-md text-base font-medium"
                        @click="mobileMenuOpen = false">
                    Profile Settings
                    </Link>

                    <Link :href="route('logout')" method="post" as="button"
                        class="text-white hover:text-purple-400 block w-full text-left px-3 py-2 rounded-md text-base font-medium"
                        @click="mobileMenuOpen = false">
                    Sign Out
                    </Link>
                </template>

                <template v-else>
                    <Link :href="route('login')"
                        class="text-white hover:text-purple-400 block px-3 py-2 rounded-md text-base font-medium"
                        @click="mobileMenuOpen = false">
                    Login
                    </Link>

                    <Link :href="route('register')"
                        class="text-white hover:text-purple-400 block px-3 py-2 rounded-md text-base font-medium"
                        @click="mobileMenuOpen = false">
                    Register
                    </Link>
                </template>
            </div>
        </div>
    </nav>
</template>

<script setup>
    import { ref } from 'vue'
    import { Link } from '@inertiajs/vue3'

    const mobileMenuOpen = ref(false)
</script>