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
                            <Link :href="route('dashboard')"
                                class="inline-flex items-center text-gray-600 hover:text-blue-600 mr-4">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Back to Dashboard
                            </Link>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">Manage Attractions</h1>
                        <p class="mt-2 text-gray-600">Add, edit, or remove attractions for your properties</p>
                    </div>
                    <img src="/seoul-station-logo.svg" alt="Seoul Station Logo" class="h-12 w-auto">
                </div>
            </div>

            <!-- Add New Attraction Button -->
            <div class="mb-6">
                <button @click="openCreateModal"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Attraction
                </button>
            </div>

            <!-- Attractions Table -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    <li v-for="attraction in attractions" :key="attraction.id">
                        <div class="px-4 py-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ attraction.name }}</div>
                                    <div class="text-sm text-gray-500">{{ attraction.area?.name }}</div>
                                    <div class="text-sm text-gray-500">{{ attraction.address }}</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button @click="openEditModal(attraction)"
                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    Edit
                                </button>
                                <button @click="deleteAttraction(attraction)"
                                    class="text-red-600 hover:text-red-900 text-sm font-medium">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
                
                <!-- Empty State -->
                <div v-if="attractions.length === 0" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No attractions</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new attraction.</p>
                    <div class="mt-6">
                        <button @click="openCreateModal"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New Attraction
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attraction Modal -->
        <AttractionModal 
            :show="showModal" 
            :attraction="selectedAttraction"
            :areas="areas"
            @close="closeModal"
            @saved="onAttractionSaved"
        />
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import NavigationBar from '@/Components/NavigationBar.vue'
import AttractionModal from '@/Components/AttractionModal.vue'

defineProps({
    attractions: Array,
    areas: Array
})

const showModal = ref(false)
const selectedAttraction = ref(null)

const openCreateModal = () => {
    selectedAttraction.value = null
    showModal.value = true
}

const openEditModal = (attraction) => {
    selectedAttraction.value = attraction
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
    selectedAttraction.value = null
}

const onAttractionSaved = () => {
    router.reload()
}

const deleteAttraction = (attraction) => {
    if (confirm('Are you sure you want to delete this attraction?')) {
        router.delete(route('attractions.destroy', attraction.uuid))
    }
}
</script>
