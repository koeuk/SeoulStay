<template>
    <div class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, #1a4a3a 0%, #0f2b24 100%); background-image: 
        linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px), 
        linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); 
        background-size: 50px 50px;">
        <div class="bg-white border-4 border-black p-8 w-full max-w-2xl">
            <!-- Header -->
            <div class="border-2 border-black mb-6 p-2">
                <h1 class="text-xl font-bold">Seoul Stay - Welcome</h1>
            </div>
            
            <!-- Logo -->
            <div class="border-2 border-black p-8 mb-6 text-center">
                <div class="text-2xl font-bold">LOGO</div>
            </div>
            
            <!-- Login Form -->
            <div class="border-2 border-black p-6">
                <h2 class="text-lg font-bold mb-4">Login</h2>
                
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Employee:</label>
                            <input 
                                v-model="form.employee"
                                type="text" 
                                class="w-full border-2 border-black p-2"
                                placeholder="Optional"
                            />
                        </div>
                        <div class="flex flex-col justify-end space-y-2">
                            <label class="flex items-center">
                                <input 
                                    v-model="form.remember" 
                                    type="checkbox" 
                                    class="mr-2"
                                /> 
                                Keep me signed in
                            </label>
                            <label class="flex items-center">
                                <input 
                                    v-model="showPassword" 
                                    type="checkbox" 
                                    class="mr-2"
                                /> 
                                Show Password
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">User:</label>
                        <input 
                            v-model="form.username"
                            type="text" 
                            class="w-full border-2 border-black p-2"
                            required
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">Password:</label>
                        <input 
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'" 
                            class="w-full border-2 border-black p-2"
                            required
                        />
                    </div>
                    
                    <!-- Error Messages -->
                    <div v-if="$page.props.errors.username" class="text-red-600 text-sm">
                        {{ $page.props.errors.username }}
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex justify-center space-x-4 pt-4">
                        <button 
                            type="submit"
                            class="bg-gray-300 border-2 border-black px-6 py-2 hover:bg-gray-400"
                            :disabled="form.processing"
                        >
                            🔑 Login
                        </button>
                        <button 
                            type="button"
                            class="bg-red-600 text-white border-2 border-black px-6 py-2 hover:bg-red-700"
                            @click="$inertia.visit('/')"
                        >
                            🚪 Exit
                        </button>
                    </div>
                    
                    <!-- Register Link -->
                    <div class="text-center pt-4">
                        <span>Don't have an account? </span>
                        <Link 
                            :href="route('register')" 
                            class="text-blue-600 underline hover:text-blue-800"
                        >
                            Create one
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

const showPassword = ref(false)

const form = useForm({
    employee: '',
    username: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('login'))
}
</script>