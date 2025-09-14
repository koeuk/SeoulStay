<template>
    <div class="min-h-screen" style="background: linear-gradient(135deg, #1a4a3a 0%, #0f2b24 100%); background-image: 
        linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px), 
        linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); 
        background-size: 50px 50px;">
        
        <!-- Navigation Bar -->
        <NavigationBar />
        
        <div class="p-4 mt-8">
            <div class="bg-white border-4 border-black max-w-6xl mx-auto">
                <!-- Header -->
                <div class="border-b-2 border-black p-4">
                    <h1 class="text-xl font-bold">Seoul Stay - Management Dashboard</h1>
                </div>

                <!-- Tab Navigation -->
                <div class="border-b-2 border-black p-4">
                    <div class="flex space-x-1">
                        <button
                            @click="activeTab = 'traveler'"
                            :class="[
                                'px-4 py-2 border-2 border-black',
                                activeTab === 'traveler' ? 'bg-white' : 'bg-gray-200'
                            ]"
                        >
                            I'm Traveler
                        </button>
                        <button
                            @click="activeTab = 'owner'"
                            :class="[
                                'px-4 py-2 border-2 border-black',
                                activeTab === 'owner' ? 'bg-white' : 'bg-gray-200'
                            ]"
                        >
                            I'm Owner / Manager
                        </button>
                    </div>
                </div>
            
                <!-- Tab Content -->
                <div class="border-2 border-black m-4 min-h-96 p-6">
                    <!-- Traveler Tab -->
                    <div v-if="activeTab === 'traveler'">
                        <!-- Search Box -->
                        <div class="mb-6">
                            <div class="relative">
                                <input
                                    v-model="searchQuery"
                                    @input="performSearch"
                                    type="text"
                                    placeholder="Search destination or Listing Title or Attraction"
                                    class="w-full border-2 border-black p-3 pl-10 rounded"
                                />
                                <span class="absolute left-3 top-3">🔍</span>
                            </div>
                        </div>

                        <!-- Search Results Table -->
                        <div v-if="filteredItems.length > 0">
                            <table class="w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 cursor-pointer" @click="sortBy('id')">
                                            ID <span v-if="sortField === 'id'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        </th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 cursor-pointer" @click="sortBy('title')">
                                            Title <span v-if="sortField === 'title'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        </th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 cursor-pointer" @click="sortBy('type')">
                                            Type <span v-if="sortField === 'type'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        </th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 cursor-pointer" @click="sortBy('area')">
                                            Area <span v-if="sortField === 'area'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        </th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 cursor-pointer" @click="sortBy('capacity')">
                                            Capacity <span v-if="sortField === 'capacity'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in filteredItems" :key="item.id"
                                        :class="index % 2 === 0 ? 'bg-white' : 'bg-blue-50'"
                                        class="hover:bg-blue-100 border-b border-gray-200">
                                        <td class="py-3 px-4 text-sm">
                                            <input type="checkbox" class="mr-2">
                                            {{ item.id || 'N/A' }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-blue-600">{{ item.title }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-600">{{ item.item_type?.name || 'N/A' }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-600">{{ item.area?.name || 'N/A' }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-600">{{ item.capacity }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty State -->
                        <div v-if="filteredItems.length === 0" class="p-8 text-center text-gray-500">
                            <p v-if="searchQuery">No items found matching "{{ searchQuery }}"</p>
                            <p v-else>No items available</p>
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
                                ➕ Add New Listing
                            </button>
                        </div>

                        <!-- User's Listings Table -->
                        <div v-if="userItems.length > 0">
                            <table class="w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 cursor-pointer" @click="sortBy('id')">
                                            ID <span v-if="sortField === 'id'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        </th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 cursor-pointer" @click="sortBy('title')">
                                            Title <span v-if="sortField === 'title'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        </th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 cursor-pointer" @click="sortBy('type')">
                                            Type <span v-if="sortField === 'type'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        </th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 cursor-pointer" @click="sortBy('area')">
                                            Area <span v-if="sortField === 'area'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        </th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 cursor-pointer" @click="sortBy('capacity')">
                                            Capacity <span v-if="sortField === 'capacity'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        </th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in userItems" :key="item.id"
                                        :class="index % 2 === 0 ? 'bg-white' : 'bg-blue-50'"
                                        class="hover:bg-blue-100 border-b border-gray-200">
                                        <td class="py-3 px-4 text-sm">
                                            <input type="checkbox" class="mr-2">
                                            {{ item.id || 'N/A' }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-blue-600">{{ item.title }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-600">{{ item.item_type?.name || 'N/A' }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-600">{{ item.area?.name || 'N/A' }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-600">{{ item.capacity }}</td>
                                        <td class="py-3 px-4 text-sm">
                                            <button
                                                @click="editListing(item)"
                                                class="text-blue-600 underline hover:text-blue-800"
                                            >
                                                Edit Details
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty State for Owner -->
                        <div v-if="userItems.length === 0" class="p-8 text-center text-gray-500">
                            <p>No listings found. Click "Add New Listing" to create your first property listing.</p>
                        </div>
                    </div>
                </div>

                <!-- Status Bar -->
                <div class="border-t-2 border-black p-2 bg-gray-100">
                    <span class="text-sm">{{ statusText }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import NavigationBar from '@/Components/NavigationBar.vue'

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

// Load data on mount
onMounted(() => {
    // Data is already passed from props
})
</script>
