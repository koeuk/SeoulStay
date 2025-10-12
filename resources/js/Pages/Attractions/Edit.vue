<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation Bar -->
        <NavigationBar />

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center mb-4">
                            <Link :href="route('attractions.index')"
                                class="inline-flex items-center text-gray-600 hover:text-blue-600 mr-4">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Back to Attractions
                            </Link>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">Edit Attraction</h1>
                        <p class="mt-2 text-gray-600">Update the attraction information</p>
                    </div>
                    <img src="/seoul-station-logo.svg" alt="Seoul Station Logo" class="h-12 w-auto">
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Attraction Information</h2>
                    <p class="text-sm text-gray-600 mt-1">Update the details below to modify the attraction</p>
                </div>

                <form @submit.prevent="submit" class="p-6">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Attraction Name *</label>
                            <input v-model="form.name" type="text" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="e.g., N Seoul Tower, Gyeongbokgung Palace"
                                required />
                            <div v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Area *</label>
                            <select v-model="form.area_id" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required>
                                <option value="">Select Area</option>
                                <option v-for="area in areas" :key="area.id" :value="area.id">
                                    {{ area.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.area_id" class="mt-1 text-sm text-red-600">
                                {{ form.errors.area_id }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <textarea v-model="form.address" rows="3"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Enter the full address of the attraction"
                                required></textarea>
                            <div v-if="form.errors.address" class="mt-1 text-sm text-red-600">
                                {{ form.errors.address }}
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-between">
                        <Link :href="route('attractions.index')"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </Link>
                        <button type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                            <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Attraction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import NavigationBar from '@/Components/NavigationBar.vue'

const props = defineProps({
    attraction: Object,
    areas: Array
})

const form = useForm({
    name: props.attraction.name || '',
    area_id: props.attraction.area_id || '',
    address: props.attraction.address || ''
})

const submit = () => {
    form.put(route('attractions.update', props.attraction.uuid))
}
</script>
