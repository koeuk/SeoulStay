<template>
    <div class="min-h-screen bg-gray-100">
        <div class="bg-white border-4 border-black">
            <!-- Header -->
            <div class="border-b-2 border-black p-4">
                <h1 class="text-xl font-bold">Seoul Stay - Management</h1>
            </div>
            
            <!-- Logo and Navigation -->
            <div class="border-b-2 border-black p-4 flex justify-between items-center">
                <div class="border-2 border-black p-4 flex-1 text-center mr-4">
                    <div class="text-2xl font-bold">LOGO</div>
                </div>
                <div class="flex items-center space-x-4">
                    <form @submit.prevent="logout" class="inline">
                        <button 
                            type="submit"
                            class="bg-gray-300 border-2 border-black px-4 py-2 hover:bg-gray-400"
                        >
                            Log out
                        </button>
                    </form>
                    <button 
                        class="bg-gray-300 border-2 border-black px-4 py-2 hover:bg-gray-400"
                        @click="exit"
                    >
                        Exit
                    </button>
                </div>
            </div>
            
            <!-- Tab Navigation -->
            <div class="border-b-2 border-black p-4">
                <div class="flex space-x-1">
                    <button 
                        @click="switchTab('traveler')"
                        :class="[
                            'px-4 py-2 border-2 border-black',
                            activeTab === 'traveler' ? 'bg-white' : 'bg-gray-200'
                        ]"
                    >
                        I'm Traveler
                    </button>
                    <button 
                        @click="switchTab('owner')"
                        :class="[
                            'px-4 py-2 border-2 border-black',
                            activeTab === 'owner' ? 'bg-white' : 'bg-gray-200'
                        ]"
                    >
                        I'm Owner / Manager
                    </button>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="border-2 border-black m-4 min-h-96">
                <!-- Search Bar -->
                <div class="p-4 border-b-2 border-black" v-if="activeTab === 'traveler'">
                    <div class="relative">
                        <input 
                            v-model="searchQuery"
                            @input="performSearch"
                            type="text" 
                            placeholder="Search destination or Listing Title or Attraction"
                            class="w-full border-2 border-black rounded-full p-3 pl-10"
                        />
                        <div class="absolute left-3 top-3.5">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Data Table -->
                <div class="p-4" v-if="activeTab === 'traveler' && filteredItems.length > 0">
                    <table class="w-full border-2 border-black">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border-2 border-black p-2 text-left cursor-pointer" @click="sortBy('title')">
                                    Title <span v-if="sortField === 'title'">{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                </th>
                                <th class="border-2 border-black p-2 text-left cursor-pointer" @click="sortBy('capacity')">
                                    Capacity <span v-if="sortField === 'capacity'">{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                </th>
                                <th class="border-2 border-black p-2 text-left cursor-pointer" @click="sortBy('area')">
                                    Area <span v-if="sortField === 'area'">{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                </th>
                                <th class="border-2 border-black p-2 text-left cursor-pointer" @click="sortBy('type')">
                                    Type <span v-if="sortField === 'type'">{{ sortOrder === 'asc' ? '▲' : '▼' }}</span>
                                </th>
                                <th class="border-2 border-black p-2 text-left" v-if="activeTab === 'owner'">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in sortedItems" :key="item.id" class="hover:bg-gray-50">
                                <td class="border-2 border-black p-2">{{ item.title }}</td>
                                <td class="border-2 border-black p-2">{{ item.capacity }}</td>
                                <td class="border-2 border-black p-2">{{ item.area?.name }}</td>
                                <td class="border-2 border-black p-2">{{ item.item_type?.name }}</td>
                                <td class="border-2 border-black p-2" v-if="activeTab === 'owner'">
                                    <div class="flex space-x-2">
                                        <Link 
                                            :href="route('items.edit', item.id)"
                                            class="text-blue-600 hover:text-blue-800"
                                        >
                                            Edit
                                        </Link>
                                        <button 
                                            @click="deleteItem(item.id)"
                                            class="text-red-600 hover:text-red-800"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Add New Listing Button for Owner Tab -->
                <div class="p-4" v-if="activeTab === 'owner'">
                    <Link 
                        :href="route('items.create')"
                        class="bg-blue-500 text-white border-2 border-black px-6 py-2 hover:bg-blue-600 inline-block"
                    >
                        Add New Listing
                    </Link>
                </div>
                
                <!-- Empty State -->
                <div v-if="filteredItems.length === 0" class="p-8 text-center text-gray-500">
                    <p v-if="searchQuery">No items found matching "{{ searchQuery }}"</p>
                    <p v-else>No items available</p>
                </div>
            </div>
            
            <!-- Status Bar -->
            <div class="border-2 border-black m-4 p-2 bg-gray-100">
                <span class="font-medium">{{ filteredItems.length }} items found.</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import axios from 'axios'

const props = defineProps({
    items: Object,
    itemsCount: Number,
    search: String,
    tab: String,
    userType: String,
    user: Object,
})

const activeTab = ref(props.tab || 'traveler')
const searchQuery = ref(props.search || '')
const sortField = ref('title')
const sortOrder = ref('asc')
const allItems = ref(props.items?.data || [])

const logoutForm = useForm({})

const filteredItems = computed(() => {
    if (!searchQuery.value) return allItems.value
    
    return allItems.value.filter(item => {
        const searchLower = searchQuery.value.toLowerCase()
        return (
            item.title?.toLowerCase().includes(searchLower) ||
            item.area?.name?.toLowerCase().includes(searchLower) ||
            item.item_type?.name?.toLowerCase().includes(searchLower)
        )
    })
})

const sortedItems = computed(() => {
    return [...filteredItems.value].sort((a, b) => {
        let aVal, bVal
        
        switch (sortField.value) {
            case 'title':
                aVal = a.title || ''
                bVal = b.title || ''
                break
            case 'capacity':
                aVal = a.capacity || 0
                bVal = b.capacity || 0
                break
            case 'area':
                aVal = a.area?.name || ''
                bVal = b.area?.name || ''
                break
            case 'type':
                aVal = a.item_type?.name || ''
                bVal = b.item_type?.name || ''
                break
            default:
                return 0
        }
        
        if (sortOrder.value === 'asc') {
            return aVal > bVal ? 1 : -1
        } else {
            return aVal < bVal ? 1 : -1
        }
    })
})

const switchTab = (tab) => {
    activeTab.value = tab
    router.get(route('dashboard'), { tab }, { preserveState: true })
}

const performSearch = async () => {
    try {
        const response = await axios.get(route('dashboard.search'), {
            params: { 
                q: searchQuery.value,
                tab: activeTab.value 
            }
        })
        allItems.value = response.data.items
    } catch (error) {
        console.error('Search failed:', error)
    }
}

const sortBy = (field) => {
    if (sortField.value === field) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortField.value = field
        sortOrder.value = 'asc'
    }
}

const deleteItem = (itemId) => {
    if (confirm('Are you sure you want to delete this item?')) {
        router.delete(route('items.destroy', itemId))
    }
}

const logout = () => {
    logoutForm.post(route('logout'))
}

const exit = () => {
    window.close()
}
</script>