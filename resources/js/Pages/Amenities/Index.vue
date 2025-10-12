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
                        <h1 class="text-3xl font-bold text-gray-900">Manage Amenities</h1>
                        <p class="mt-2 text-gray-600">Add, edit, or remove amenities for your properties</p>
                    </div>
                    <img src="/seoul-station-logo.svg" alt="Seoul Station Logo" class="h-12 w-auto">
                </div>
            </div>

            <!-- Add New Amenity Button -->
            <div class="mb-6">
                <button @click="openCreateModal"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Amenity
                </button>
            </div>

            <!-- Amenities Table -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    <li v-for="amenity in amenities" :key="amenity.id">
                        <div class="px-4 py-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ amenity.name }}</div>
                                    <div v-if="amenity.icon_name" class="text-sm text-gray-500">{{ amenity.icon_name }}</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button @click="openEditModal(amenity)"
                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    Edit
                                </button>
                                <button @click="deleteAmenity(amenity)"
                                    class="text-red-600 hover:text-red-900 text-sm font-medium">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
                
                <!-- Empty State -->
                <div v-if="amenities.length === 0" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No amenities</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new amenity.</p>
                    <div class="mt-6">
                        <button @click="openCreateModal"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New Amenity
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Amenity Modal -->
        <AmenityModal 
            :show="showModal" 
            :amenity="selectedAmenity"
            @close="closeModal"
            @saved="onAmenitySaved"
        />
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import NavigationBar from '@/Components/NavigationBar.vue'
import AmenityModal from '@/Components/AmenityModal.vue'

defineProps({
    amenities: Array
})

const showModal = ref(false)
const selectedAmenity = ref(null)

const openCreateModal = () => {
    selectedAmenity.value = null
    showModal.value = true
}

const openEditModal = (amenity) => {
    selectedAmenity.value = amenity
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
    selectedAmenity.value = null
}

const onAmenitySaved = () => {
    router.reload()
}

const deleteAmenity = (amenity) => {
    if (confirm('Are you sure you want to delete this amenity?')) {
        router.delete(route('amenities.destroy', amenity.uuid))
    }
}
</script>
