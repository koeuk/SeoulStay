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
                    <h1 class="text-xl font-bold">Seoul Stay sfsfs- Management Dashboard</h1>
                </div>

                <!-- Tab Navigation -->
                <div class="border-b-2 border-black p-4">
                    <div class="flex space-x-1">
                        <button @click="switchTab('traveler')" :class="[
                            'px-4 py-2 border-2 border-black',
                            activeTab === 'traveler' ? 'bg-white' : 'bg-gray-200'
                        ]">
                            I'm Traveler
                        </button>
                        <button @click="switchTab('owner')" :class="[
                            'px-4 py-2 border-2 border-black',
                            activeTab === 'owner' ? 'bg-white' : 'bg-gray-200'
                        ]">
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
                                <input v-model="searchQuery" @input="performSearch" type="text"
                                    placeholder="Search destination or Listing Title or Attraction"
                                    class="w-full border-2 border-black p-3 pl-10 rounded" />
                                <span class="absolute left-3 top-3">🔍</span>
                            </div>
                        </div>

                        <!-- Search Results Table -->
                        <div class="border-2 border-black" v-if="filteredItems.length > 0">
                            <table class="w-full">
                                <thead class="bg-gray-200 border-b-2 border-black">
                                    <tr>
                                        <th class="border-r border-black p-3 text-left cursor-pointer"
                                            @click="sortBy('title')">
                                            Title <span v-if="sortField === 'title'">{{ sortOrder === 'asc' ? '▲' : '▼'
                                                }}</span>
                                        </th>
                                        <th class="border-r border-black p-3 text-left cursor-pointer"
                                            @click="sortBy('capacity')">
                                            Capacity <span v-if="sortField === 'capacity'">{{ sortOrder === 'asc' ? '▲'
                                                : '▼' }}</span>
                                        </th>
                                        <th class="border-r border-black p-3 text-left cursor-pointer"
                                            @click="sortBy('area')">
                                            Area <span v-if="sortField === 'area'">{{ sortOrder === 'asc' ? '▲' : '▼'
                                                }}</span>
                                        </th>
                                        <th class="p-3 text-left cursor-pointer" @click="sortBy('type')">
                                            Type <span v-if="sortField === 'type'">{{ sortOrder === 'asc' ? '▲' : '▼'
                                                }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in sortedItems" :key="item.id"
                                        class="border-b border-black hover:bg-gray-50">
                                        <td class="border-r border-black p-3">{{ item.title }}</td>
                                        <td class="border-r border-black p-3">{{ item.capacity }}</td>
                                        <td class="border-r border-black p-3">{{ item.area?.name || 'N/A' }}</td>
                                        <td class="p-3">{{ item.item_type?.name || 'N/A' }}</td>
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
                            <Link :href="route('items.create')"
                                class="bg-gray-300 border-2 border-black px-6 py-2 hover:bg-gray-400 font-medium">
                            ➕ Add New Listing
                            </Link>
                        </div>

                        <!-- User's Listings Table -->
                        <div class="border-2 border-black" v-if="filteredItems.length > 0">
                            <table class="w-full">
                                <thead class="bg-gray-200 border-b-2 border-black">
                                    <tr>
                                        <th class="border-r border-black p-3 text-left cursor-pointer"
                                            @click="sortBy('title')">
                                            Title <span v-if="sortField === 'title'">{{ sortOrder === 'asc' ? '▲' : '▼'
                                                }}</span>
                                        </th>
                                        <th class="border-r border-black p-3 text-left cursor-pointer"
                                            @click="sortBy('capacity')">
                                            Capacity <span v-if="sortField === 'capacity'">{{ sortOrder === 'asc' ? '▲'
                                                : '▼' }}</span>
                                        </th>
                                        <th class="border-r border-black p-3 text-left cursor-pointer"
                                            @click="sortBy('area')">
                                            Area <span v-if="sortField === 'area'">{{ sortOrder === 'asc' ? '▲' : '▼'
                                                }}</span>
                                        </th>
                                        <th class="border-r border-black p-3 text-left cursor-pointer"
                                            @click="sortBy('type')">
                                            Type <span v-if="sortField === 'type'">{{ sortOrder === 'asc' ? '▲' : '▼'
                                                }}</span>
                                        </th>
                                        <th class="p-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in sortedItems" :key="item.id"
                                        class="border-b border-black hover:bg-gray-50">
                                        <td class="border-r border-black p-3">{{ item.title }}</td>
                                        <td class="border-r border-black p-3">{{ item.capacity }}</td>
                                        <td class="border-r border-black p-3">{{ item.area?.name || 'N/A' }}</td>
                                        <td class="border-r border-black p-3">{{ item.item_type?.name || 'N/A' }}</td>
                                        <td class="p-3 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <Link :href="route('items.edit', item.id)"
                                                    class="text-blue-600 underline hover:text-blue-800">
                                                Edit Details
                                                </Link>
                                                <button @click="deleteItem(item.id)"
                                                    class="text-red-600 underline hover:text-red-800">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty State for Owner -->
                        <div v-if="filteredItems.length === 0" class="p-8 text-center text-gray-500">
                            <p>No listings found. Click "Add New Listing" to create your first property listing.</p>
                        </div>
                    </div>
                </div>

                <!-- Status Bar -->
                <div class="border-t-2 border-black p-2 bg-gray-100">
                    <span class="text-sm">{{ filteredItems.length }} items found.</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 p-4">
                    <button @click="logout"
                        class="bg-red-600 text-white border-2 border-black px-6 py-2 hover:bg-red-700">
                        Log out
                    </button>
                    <button @click="exit" class="bg-gray-300 border-2 border-black px-6 py-2 hover:bg-gray-400">
                        Exit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, computed, onMounted } from 'vue'
    import { Link, useForm, router } from '@inertiajs/vue3'
    import NavigationBar from '@/Components/NavigationBar.vue'
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