<template>
    <div class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, #1a4a3a 0%, #0f2b24 100%); background-image: 
        linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px), 
        linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); 
        background-size: 50px 50px;">
        <div class="bg-white border-4 border-black p-8 w-full max-w-3xl">
            <!-- Header -->
            <div class="border-2 border-black mb-6 p-2">
                <h1 class="text-xl font-bold">Seoul Stay - Create Account</h1>
            </div>
            
            <!-- Your Information Section -->
            <div class="border-2 border-black p-6">
                <h2 class="text-lg font-bold mb-4">Your Information</h2>
                
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Username:</label>
                            <input 
                                v-model="form.username"
                                type="text" 
                                class="w-full border-2 border-black p-2"
                                required
                            />
                            <div v-if="form.errors.username" class="text-red-600 text-sm mt-1">
                                {{ form.errors.username }}
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input 
                                    v-model="form.gender" 
                                    type="radio" 
                                    value="Male"
                                    class="mr-2"
                                    required
                                /> 
                                Male
                            </label>
                            <label class="flex items-center">
                                <input 
                                    v-model="form.gender" 
                                    type="radio" 
                                    value="Female"
                                    class="mr-2"
                                    required
                                /> 
                                Female
                            </label>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Full Name:</label>
                            <input 
                                v-model="form.full_name"
                                type="text" 
                                class="w-full border-2 border-black p-2"
                                required
                            />
                            <div v-if="form.errors.full_name" class="text-red-600 text-sm mt-1">
                                {{ form.errors.full_name }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Number of Family Members:</label>
                            <div class="relative">
                                <input 
                                    v-model.number="form.family_count"
                                    type="number" 
                                    min="0"
                                    max="20"
                                    class="w-full border-2 border-black p-2 pr-8"
                                    required
                                />
                                <span class="absolute right-2 top-2">👨‍👩‍👧‍👦</span>
                            </div>
                            <div v-if="form.errors.family_count" class="text-red-600 text-sm mt-1">
                                {{ form.errors.family_count }}
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">Birthday:</label>
                        <div class="flex items-center space-x-2">
                            <input 
                                v-model="form.birth_date"
                                type="date" 
                                class="border-2 border-black p-2"
                                required
                            />
                            <span class="text-2xl">📅</span>
                        </div>
                        <div v-if="form.errors.birth_date" class="text-red-600 text-sm mt-1">
                            {{ form.errors.birth_date }}
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Password:</label>
                            <input 
                                v-model="form.password"
                                type="password" 
                                class="w-full border-2 border-black p-2"
                                required
                                minlength="5"
                            />
                            <div v-if="form.errors.password" class="text-red-600 text-sm mt-1">
                                {{ form.errors.password }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Retype Password:</label>
                            <input 
                                v-model="form.password_confirmation"
                                type="password" 
                                class="w-full border-2 border-black p-2"
                                required
                                minlength="5"
                            />
                            <div v-if="form.errors.password_confirmation" class="text-red-600 text-sm mt-1">
                                {{ form.errors.password_confirmation }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="flex items-center justify-between pt-4">
                        <label class="flex items-center">
                            <input 
                                v-model="form.terms" 
                                type="checkbox" 
                                class="mr-2"
                                :disabled="!termsViewed"
                                required
                            /> 
                            I agree to the Terms and Conditions
                        </label>
                        <button 
                            type="button"
                            @click="viewTerms"
                            class="text-blue-600 underline hover:text-blue-800"
                        >
                            View Terms and Conditions
                        </button>
                    </div>
                    
                    <!-- Terms Modal -->
                    <div v-if="showTermsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white border-4 border-black p-6 max-w-2xl max-h-96 overflow-y-auto">
                            <h3 class="text-lg font-bold mb-4">Terms and Conditions</h3>
                            <pre class="text-sm whitespace-pre-wrap">{{ termsContent }}</pre>
                            <div class="flex justify-end pt-4">
                                <button 
                                    type="button"
                                    @click="closeTerms"
                                    class="bg-gray-300 border-2 border-black px-4 py-2 hover:bg-gray-400"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex justify-center space-x-4 pt-6">
                        <button 
                            type="submit"
                            class="bg-gray-300 border-2 border-black px-6 py-2 hover:bg-gray-400"
                            :disabled="form.processing"
                        >
                            Register & login
                        </button>
                        <Link 
                            :href="route('login')"
                            class="bg-gray-300 border-2 border-black px-6 py-2 hover:bg-gray-400 inline-block"
                        >
                            Return login form
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

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