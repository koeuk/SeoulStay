<template>
    <div class="min-h-screen" style="background: linear-gradient(135deg, #1a4a3a 0%, #0f2b24 100%); background-image: 
        linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px), 
        linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); 
        background-size: 50px 50px;">
        <div class="bg-white border-4 border-black mx-auto max-w-7xl">
            <!-- Header -->
            <div class="border-b-2 border-black p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Seoul Stay - Management</h1>
                <div class="space-x-2">
                    <button 
                        @click="logout"
                        class="bg-gray-300 border-2 border-black px-4 py-2 hover:bg-gray-400"
                    >
                        Log out
                    </button>
                    <button 
                        @click="exit"
                        class="bg-gray-300 border-2 border-black px-4 py-2 hover:bg-gray-400"
                    >
                        Exit
                    </button>
                </div>
            </div>
            
            <!-- Logo -->
            <div class="border-b-2 border-black p-8 text-center">
                <div class="text-2xl font-bold">LOGO</div>
            </div>
            
            <!-- Tab Navigation -->
            <div class="border-b-2 border-black flex">
                <button 
                    @click="activeTab = 'traveler'"
                    :class="[
                        'px-6 py-3 border-r-2 border-black font-medium',
                        activeTab === 'traveler' ? 'bg-gray-200' : 'bg-white hover:bg-gray-100'
                    ]"
                >
                    I'm Traveler
                </button>
                <button 
                    @click="activeTab = 'owner'"
                    :class="[
                        'px-6 py-3 font-medium',
                        activeTab === 'owner' ? 'bg-gray-200' : 'bg-white hover:bg-gray-100'
                    ]"
                >
                    I'm Owner / Manager
                </button>
            </div>
            
            <!-- Tab Content -->
            <div class="p-6 min-h-96">
                <!-- Traveler Tab -->
                <div v-if="activeTab === 'traveler'">
                    <!-- Search Box -->
                    <div class="mb-6">
                        <div class="relative">
                            <span class="absolute left-3 top-3">🔍</span>
                            <input 
                                v-model="searchQuery"
                                @input="performSearch"
                                type="text" 
                                placeholder="Search destination or Listing Title or Attraction"
                                class="w-full border-2 border-black p-3 pl-10 rounded"
                            />
                        </div>
                    </div>
                    
                    <!-- Search Results Table -->
                    <div class="border-2 border-black">
                        <table class="w-full">
                            <thead class="bg-gray-200 border-b-2 border-black">
                                <tr>
                                    <th class="border-r border-black p-3 text-left cursor-pointer" @click="sortBy('title')">
                                        Title ▲
                                    </th>
                                    <th class="border-r border-black p-3 text-left cursor-pointer" @click="sortBy('capacity')">
                                        Capacity
                                    </th>
                                    <th class="border-r border-black p-3 text-left cursor-pointer" @click="sortBy('area')">
                                        Area
                                    </th>
                                    <th class="p-3 text-left cursor-pointer" @click="sortBy('type')">
                                        Type
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in filteredItems" :key="item.id" class="border-b border-black hover:bg-gray-50">
                                    <td class="border-r border-black p-3">{{ item.title }}</td>
                                    <td class="border-r border-black p-3">{{ item.capacity }}</td>
                                    <td class="border-r border-black p-3">{{ item.area?.name || 'N/A' }}</td>
                                    <td class="p-3">{{ item.item_type?.name || 'N/A' }}</td>
                                </tr>
                                <tr v-if="filteredItems.length === 0">
                                    <td colspan="4" class="p-6 text-center text-gray-500">
                                        No listings found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Owner/Manager Tab -->
                <div v-if="activeTab === 'owner'">
                    <!-- Add Listing Button -->
                    <div class="mb-6">
                        <button 
                            @click="addListing"
                            class="bg-gray-300 border-2 border-black px-6 py-2 hover:bg-gray-400 font-medium"
                        >
                            ➕ Add Listing
                        </button>
                    </div>
                    
                    <!-- User's Listings Table -->
                    <div class="border-2 border-black">
                        <table class="w-full">
                            <thead class="bg-gray-200 border-b-2 border-black">
                                <tr>
                                    <th class="border-r border-black p-3 text-left cursor-pointer" @click="sortBy('title')">
                                        Title ▲
                                    </th>
                                    <th class="border-r border-black p-3 text-left cursor-pointer" @click="sortBy('capacity')">
                                        Capacity
                                    </th>
                                    <th class="border-r border-black p-3 text-left cursor-pointer" @click="sortBy('area')">
                                        Area
                                    </th>
                                    <th class="border-r border-black p-3 text-left cursor-pointer" @click="sortBy('type')">
                                        Type
                                    </th>
                                    <th class="p-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in userItems" :key="item.id" class="border-b border-black hover:bg-gray-50">
                                    <td class="border-r border-black p-3">{{ item.title }}</td>
                                    <td class="border-r border-black p-3">{{ item.capacity }}</td>
                                    <td class="border-r border-black p-3">{{ item.area?.name || 'N/A' }}</td>
                                    <td class="border-r border-black p-3">{{ item.item_type?.name || 'N/A' }}</td>
                                    <td class="p-3 text-center">
                                        <button 
                                            @click="editListing(item)"
                                            class="text-blue-600 underline hover:text-blue-800"
                                        >
                                            Edit Details
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="userItems.length === 0">
                                    <td colspan="5" class="p-6 text-center text-gray-500">
                                        No listings found. Click "Add Listing" to create your first property listing.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Status Bar -->
            <div class="border-t-2 border-black p-2 bg-gray-100">
                <span class="text-sm">{{ statusText }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head, router } from '@inertiajs/vue3'

// Define props
const props = defineProps({
    auth: Object,
    items: {
        type: Array,
        default: () => []
    },
    userItems: {
        type: Array,
        default: () => []
    }
})

// Reactive data
const activeTab = ref('traveler')
const searchQuery = ref('')
const sortField = ref('title')
const sortDirection = ref('asc')
const allItems = ref(props.items || [])
const userItems = ref(props.userItems || [])

// Computed properties
const filteredItems = computed(() => {
    let items = allItems.value
    
    // Filter by search query
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        items = items.filter(item => 
            item.title?.toLowerCase().includes(query) ||
            item.area?.name?.toLowerCase().includes(query) ||
            item.item_type?.name?.toLowerCase().includes(query) ||
            item.approximate_address?.toLowerCase().includes(query)
        )
    }
    
    // Sort items
    items.sort((a, b) => {
        let aVal = a[sortField.value]
        let bVal = b[sortField.value]
        
        if (sortField.value === 'area') {
            aVal = a.area?.name || ''
            bVal = b.area?.name || ''
        } else if (sortField.value === 'type') {
            aVal = a.item_type?.name || ''
            bVal = b.item_type?.name || ''
        }
        
        if (sortDirection.value === 'asc') {
            return aVal > bVal ? 1 : -1
        } else {
            return aVal < bVal ? 1 : -1
        }
    })
    
    return items
})

const statusText = computed(() => {
    if (activeTab.value === 'traveler') {
        return `${filteredItems.value.length} items found.`
    } else {
        return `${userItems.value.length} items found.`
    }
})

// Methods
const performSearch = () => {
    // Search is reactive through computed property
}

const sortBy = (field) => {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortField.value = field
        sortDirection.value = 'asc'
    }
}

const addListing = () => {
    router.visit('/items/create')
}

const editListing = (item) => {
    router.visit(`/items/${item.uuid}/edit`)
}

const logout = () => {
    router.post('/logout')
}

const exit = () => {
    if (confirm('Are you sure you want to exit?')) {
        window.close()
    }
}

// Load data on mount
onMounted(() => {
    // Data is already passed from props
})
</script>
