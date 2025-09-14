<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 ">
        <!-- Navigation Bar -->
        <NavigationBar />

        <div class="flex items-center justify-center bg-red p-4 py-8">
            <div class="w-full max-w-2xl bg-white p-6 rounded-2xl">
                <!-- Logo Section -->
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full shadow-lg mb-4">
                        <svg class="w-10 h-10 " fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Seoul Stay</h1>
                    <p class="">Create your account</p>
                </div>

                <!-- Registration Form -->
                <div class="bg-white rounded-2xl shadow-xl border p-8">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Username and Gender Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium  mb-2">Username</label>
                                <input v-model="form.username" type="text"
                                    class="w-full px-4 py-3 bg-white/5 border rounded-lg  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Choose your username" required />
                                <div v-if="form.errors.username"
                                    class="bg-red-500/10 border border-red-500/20 rounded-lg p-2 mt-2">
                                    <p class="text-red-400 text-sm">{{ form.errors.username }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium  mb-2">Gender</label>
                                <div class="flex space-x-6 pt-3">
                                    <label class="flex items-center ">
                                        <input v-model="form.gender" type="radio" value="Male"
                                            class="w-4 h-4 text-purple-600 bg-white/5 focus:ring-purple-500 focus:ring-2"
                                            required />
                                        <span class="ml-2">Male</span>
                                    </label>
                                    <label class="flex items-center ">
                                        <input v-model="form.gender" type="radio" value="Female"
                                            class="w-4 h-4 text-purple-600 bg-white/5 focus:ring-purple-500 focus:ring-2"
                                            required />
                                        <span class="ml-2">Female</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Full Name and Family Count Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium  mb-2">Full Name</label>
                                <input v-model="form.full_name" type="text"
                                    class="w-full px-4 py-3 bg-white/5 border rounded-lg  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Enter your full name" required />
                                <div v-if="form.errors.full_name"
                                    class="bg-red-500/10 border border-red-500/20 rounded-lg p-2 mt-2">
                                    <p class="text-red-400 text-sm">{{ form.errors.full_name }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium  mb-2">Family Members</label>
                                <div class="relative">
                                    <input v-model.number="form.family_count" type="number" min="0" max="20"
                                        class="w-full px-4 py-3 pr-12 bg-white/5 border rounded-lg  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                        placeholder="0" required />
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div v-if="form.errors.family_count"
                                    class="bg-red-500/10 border border-red-500/20 rounded-lg p-2 mt-2">
                                    <p class="text-red-400 text-sm">{{ form.errors.family_count }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Birthday -->
                        <div>
                            <label class="block text-sm font-medium  mb-2">Date of Birth</label>
                            <div class="relative">
                                <input v-model="form.birth_date" type="date"
                                    class="w-full px-4 py-3 pr-12 bg-white/5 border rounded-lg  focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    required />
                                <div
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div v-if="form.errors.birth_date"
                                class="bg-red-500/10 border border-red-500/20 rounded-lg p-2 mt-2">
                                <p class="text-red-400 text-sm">{{ form.errors.birth_date }}</p>
                            </div>
                        </div>

                        <!-- Password Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium  mb-2">Password</label>
                                <input v-model="form.password" type="password"
                                    class="w-full px-4 py-3 bg-white/5 border rounded-lg  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Create password" required minlength="5" />
                                <div v-if="form.errors.password"
                                    class="bg-red-500/10 border border-red-500/20 rounded-lg p-2 mt-2">
                                    <p class="text-red-400 text-sm">{{ form.errors.password }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium  mb-2">Confirm Password</label>
                                <input v-model="form.password_confirmation" type="password"
                                    class="w-full px-4 py-3 bg-white/5 border rounded-lg  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Repeat password" required minlength="5" />
                                <div v-if="form.errors.password_confirmation"
                                    class="bg-red-500/10 border border-red-500/20 rounded-lg p-2 mt-2">
                                    <p class="text-red-400 text-sm">{{ form.errors.password_confirmation }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="border-t border-white pt-6">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                                <label class="flex items-start ">
                                    <input v-model="form.terms" type="checkbox"
                                        class="w-4 h-4 text-purple-600 bg-white/5 rounded focus:ring-purple-500 focus:ring-2 mt-0.5"
                                        :disabled="!termsViewed" required />
                                    <span class="ml-2 text-sm">I agree to the Terms and Conditions</span>
                                </label>
                                <button type="button" @click="viewTerms"
                                    class="text-purple-400 hover:text-purple-300 font-medium text-sm transition-colors duration-200 underline">
                                    View Terms
                                </button>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <button type="submit"
                                class="flex-1 border bg-black text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-[1.02] focus:ring-2 focus:ring-offset-2 focus:ring-offset-transparent disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                :disabled="form.processing || !form.terms">
                                <span v-if="!form.processing" class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                    Register & Login
                                </span>
                                <span v-else class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4" />
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                    </svg>
                                    Creating Account...
                                </span>
                            </button>

                            <Link :href="route('login')"
                                class="flex-1 bg-white/5 hover:bg-white/10  hover: border font-medium py-3 px-6 rounded-lg transition-all duration-200 text-center">
                            Back to Login
                            </Link>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- Terms Modal -->
        <div v-if="showTermsModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 bg-red">
            <div class="bg-white border-black max-w-2xl w-full max-h-100 overflow-hidden ">
                <!-- Header -->
                <div class="border-b-2 border-black m-3 p-4">
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
    </div>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3'
    import { Link } from '@inertiajs/vue3'
    import { ref } from 'vue'
    import NavigationBar from '@/Components/NavigationBar.vue'

    const showTermsModal = ref(false)
    const termsViewed = ref(false)
    const termsContent = ref('')

    const form = useForm({
        username: '',
        full_name: '',
        gender: '',
        family_count: 1,
        birth_date: '',
        password: '',
        password_confirmation: '',
        terms: false,
    })

    const viewTerms = async () => {
        try {
            const response = await fetch('/Terms.txt')
            termsContent.value = await response.text()
            showTermsModal.value = true
        } catch (error) {
            console.error('Failed to load terms:', error)
            alert('Failed to load terms and conditions. Please try again.')
        }
    }

    const closeTerms = () => {
        showTermsModal.value = false
        termsViewed.value = true
    }

    const submit = () => {
        if (!termsViewed.value) {
            alert('You must view the Terms and Conditions before registering.')
            return
        }
        form.post(route('register'))
    }
</script>