<template>
    <!-- Modal Backdrop -->
    <div v-if="show" class="fixed inset-0 z-50 overflow-hidden">
        <!-- Background Overlay -->
        <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="close"></div>
        
        <!-- Modal Panel -->
        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <div class="relative w-screen max-w-md">
                <!-- Modal Content -->
                <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll">
                    <!-- Header -->
                    <div class="px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <button @click="close" class="rounded-md text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ isEditing ? 'Edit Attraction' : 'Add New Attraction' }}
                                </h2>
                            </div>
                            <button @click="close" class="rounded-md text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form Content -->
                    <div class="mt-6 flex-1 px-4 sm:px-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Attraction Name -->
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

                            <!-- Area Selection -->
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

                            <!-- Address -->
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
                        </form>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex-shrink-0 px-4 py-4 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <button @click="close" type="button"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                            <button @click="submit" type="button"
                                :disabled="form.processing"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                                <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ isEditing ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    attraction: {
        type: Object,
        default: null
    },
    areas: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits(['close', 'saved'])

const isEditing = ref(false)

const form = useForm({
    name: '',
    area_id: '',
    address: ''
})

// Watch for attraction changes
watch(() => props.attraction, (newAttraction) => {
    if (newAttraction) {
        isEditing.value = true
        form.name = newAttraction.name || ''
        form.area_id = newAttraction.area_id || ''
        form.address = newAttraction.address || ''
    } else {
        isEditing.value = false
        form.reset()
    }
}, { immediate: true })

// Watch for modal show/hide
watch(() => props.show, (newShow) => {
    if (!newShow) {
        form.reset()
        form.clearErrors()
    }
})

const close = () => {
    emit('close')
}

const submit = () => {
    if (isEditing.value) {
        form.put(route('attractions.update', props.attraction.uuid), {
            onSuccess: () => {
                emit('saved')
                close()
            }
        })
    } else {
        form.post(route('attractions.store'), {
            onSuccess: () => {
                emit('saved')
                close()
            }
        })
    }
}
</script>
