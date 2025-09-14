<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <!-- Navigation Bar -->
        <NavigationBar />

        <div class="flex items-center justify-center px-4 py-8">
            <div class="w-full max-w-2xl bg-white rounded-2xl">
                <!-- Main Container -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-xl border p-8">
                    <!-- Header -->
                    <div class="text-start mb-6 pb-4 border-b border-white/20">
                        <h1 class="text-2xl font-bold ">Seoul Stay - Welcome</h1>
                    </div>

                    <!-- Logo Section -->
                    <div class="text-center  rounded-lg">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full shadow-lg mb-4">
                            <svg class="w-10 h-10 " fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Login Form Section -->
                    <div class="border rounded-lg p-6 bg-white/5">
                        <h2 class="text-xl font-bold  mb-6">Login</h2>

                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Main Form Fields Layout -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Left Column -->
                                <div class="space-y-4">
                                    <!-- Employee Field -->
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Employee:</label>
                                        <input v-model="form.employee" type="text"
                                            class="w-full px-4 py-3 bg-white/5 border rounded-lg  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Optional" />
                                    </div>

                                    <!-- Username Field -->
                                    <div>
                                        <label class="block text-sm font-medium mb-2">User:</label>
                                        <input v-model="form.username" type="text"
                                            class="w-full px-4 py-3 bg-white/5 border rounded-lg  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Enter your username" required />
                                    </div>

                                    <!-- Password Field -->
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Password:</label>
                                        <div class="relative">
                                            <input v-model="form.password" :type="showPassword ? 'text' : 'password'"
                                                class="w-full px-4 py-3 pr-12 bg-white/5 border rounded-lg  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                                placeholder="Enter your password" required />
                                            <button type="button" @click="showPassword = !showPassword"
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-200 transition-colors">
                                                <svg v-if="!showPassword" class="w-5 h-5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Checkboxes -->
                                <div class="flex flex-col justify-end space-y-4">
                                    <label class="flex items-center">
                                        <input v-model="form.remember" type="checkbox"
                                            class="w-4 h-4 text-purple-600 bg-white/5 rounded focus:ring-purple-500 focus:ring-2" />
                                        <span class="ml-2 text-sm">Keep me signed in</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input v-model="showPassword" type="checkbox"
                                            class="w-4 h-4 text-purple-600 bg-white/5 rounded focus:ring-purple-500 focus:ring-2" />
                                        <span class="ml-2 text-sm">Show Password</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Error Messages -->
                            <div v-if="$page.props.errors.username"
                                class="bg-red-500/10 border border-red-500/20 rounded-lg p-3">
                                <p class="text-red-400 text-sm">{{ $page.props.errors.username }}</p>
                            </div>
                            <!-- Terms Modal -->
                            <div v-if="showTermsModal"
                                class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                                <div class="bg-white border-4 border-black max-w-2xl w-full max-h-96 overflow-hidden">
                                    <!-- Header -->
                                    <div class="border-b-2 border-black p-4">
                                        <h3 class="text-lg font-bold text-black">Terms and Conditions</h3>
                                    </div>
                                    <!-- Content -->
                                    <div class="p-4 max-h-64 overflow-y-auto">
                                        <pre class="text-sm text-black whitespace-pre-wrap">{{ termsContent }}</pre>
                                    </div>
                                    <!-- Footer -->
                                    <div class="border-t-2 border-black p-4 flex justify-end">
                                        <button type="button" @click="closeTerms"
                                            class="bg-gray-300 border-2 border-black px-4 py-2 hover:bg-gray-400 font-medium">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-center space-x-4 pt-6">
                                <button type="submit"
                                class=" bg-black text-white font-semibold py-3 px-8 rounded-lg transition-all duration-200 flex items-center" 
                                    :disabled="form.processing ">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Login
                                </button>

                                <button type="button"
                                    class=" hover:text-red-300 border border-red-500/30 font-semibold py-3 px-8 rounded-lg transition-all duration-200 flex items-center"
                                    @click="$inertia.visit('/')">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Exit
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center pt-4">
                                <span class="text-gray-600">Don't have an account? </span>
                                <Link :href="route('register')"
                                    class="text-purple-400 hover:text-purple-300 font-medium transition-colors duration-200 underline">
                                Create one
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3'
    import { Link } from '@inertiajs/vue3'
    import { ref } from 'vue'
    import NavigationBar from '@/Components/NavigationBar.vue'

    const showPassword = ref(false)
    const showTermsModal = ref(false)
    const termsViewed = ref(false)
    const termsContent = ref('')

    const form = useForm({
        employee: '',
        username: '',
        password: '',
        remember: false,
        terms: false,
    })
    const closeTerms = () => {
        showTermsModal.value = false
        termsViewed.value = true
    }

    const submit = () => {
        form.post(route('login'))
    }
</script>