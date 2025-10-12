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
                        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                        <p class="mt-2 text-gray-600">Manage your Seoul Stay Items</p>
                    </div>
                    <img src="/seoul-station-logo.svg" alt="Seoul Station Logo" class="h-12 w-auto">
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Properties</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ allItems.length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Your Listings</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ userItems.length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Available Now</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ filteredItems.length }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button @click="activeTab = 'traveler'" 
                            :class="[
                                'py-4 px-1 border-b-2 font-medium text-sm transition-colors',
                                activeTab === 'traveler' 
                                    ? 'border-blue-500 text-blue-600' 
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                            ]">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span>I'm Traveler</span>
                            </div>
                        </button>
                        <button @click="activeTab = 'owner'" 
                            :class="[
                                'py-4 px-1 border-b-2 font-medium text-sm transition-colors',
                                activeTab === 'owner' 
                                    ? 'border-blue-500 text-blue-600' 
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                            ]">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span>I'm Owner / Manager</span>
                            </div>
                        </button>
                    </nav>
                </div>


                <!-- Search and Action Bar -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                        <!-- Search Box for Traveler -->
                        <div v-if="activeTab === 'traveler'" class="flex-1 max-w-md">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input v-model="searchQuery" @input="performSearch" type="text"
                                    placeholder="Search destinations, properties, or attractions..."
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                            </div>
                        </div>
                        
                        <!-- Action Button for Owner -->
                        <div v-if="activeTab === 'owner'" class="flex items-center space-x-3">
                            <button @click="addListing"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Listing
                            </button>
                        </div>
                        
                        <!-- Results Summary -->
                        <div class="text-sm text-gray-500">
                            <span v-if="activeTab === 'traveler'">{{ filteredItems.length }} properties found</span>
                            <span v-else>{{ userItems.length }} properties managed</span>
                        </div>
                    </div>
                </div>
                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Traveler Tab -->
                    <div v-if="activeTab === 'traveler'">
                        <!-- Search Results -->
                        <div v-if="filteredItems.length > 0">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                                @click="sortBy('title')">
                                                <div class="flex items-center space-x-1">
                                                    <span>Title</span>
                                                    <svg v-if="sortField === 'title'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path v-if="sortDirection === 'asc'" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                                        <path v-else d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                                    </svg>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                                @click="sortBy('type')">
                                                <div class="flex items-center space-x-1">
                                                    <span>Type</span>
                                                    <svg v-if="sortField === 'type'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path v-if="sortDirection === 'asc'" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                                        <path v-else d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                                    </svg>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                                @click="sortBy('area')">
                                                <div class="flex items-center space-x-1">
                                                    <span>Area</span>
                                                    <svg v-if="sortField === 'area'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path v-if="sortDirection === 'asc'" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                                        <path v-else d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                                    </svg>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                                @click="sortBy('capacity')">
                                                <div class="flex items-center space-x-1">
                                                    <span>Capacity</span>
                                                    <svg v-if="sortField === 'capacity'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path v-if="sortDirection === 'asc'" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                                        <path v-else d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                                    </svg>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Details
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="item in filteredItems" :key="item.id" class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ item.title }}</div>
                                                        <div class="text-sm text-gray-500">{{ item.approximate_address }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ item.item_type?.name || 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ item.area?.name || 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                    </svg>
                                                    {{ item.capacity }} guests
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button class="text-blue-600 hover:text-blue-900">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-else class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No properties found</h3>
                            <p class="mt-1 text-sm text-gray-500" v-if="searchQuery">
                                No properties match your search for "{{ searchQuery }}".
                            </p>
                            <p class="mt-1 text-sm text-gray-500" v-else>
                                No properties are currently available.
                            </p>
                        </div>
                    </div>

                    <!-- Owner/Manager Tab -->
                    <div v-if="activeTab === 'owner'">
                        <!-- User's Listings -->
                        <div v-if="userItems.length > 0">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                                @click="sortBy('title')">
                                                <div class="flex items-center space-x-1">
                                                    <span>Property</span>
                                                    <svg v-if="sortField === 'title'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path v-if="sortDirection === 'asc'" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                                        <path v-else d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                                    </svg>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                                @click="sortBy('type')">
                                                <div class="flex items-center space-x-1">
                                                    <span>Type</span>
                                                    <svg v-if="sortField === 'type'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path v-if="sortDirection === 'asc'" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                                        <path v-else d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                                    </svg>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                                @click="sortBy('area')">
                                                <div class="flex items-center space-x-1">
                                                    <span>Area</span>
                                                    <svg v-if="sortField === 'area'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path v-if="sortDirection === 'asc'" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                                        <path v-else d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                                    </svg>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                                @click="sortBy('capacity')">
                                                <div class="flex items-center space-x-1">
                                                    <span>Capacity</span>
                                                    <svg v-if="sortField === 'capacity'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path v-if="sortDirection === 'asc'" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                                        <path v-else d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                                    </svg>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="item in userItems" :key="item.id" class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ item.title }}</div>
                                                        <div class="text-sm text-gray-500">{{ item.approximate_address }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ item.item_type?.name || 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ item.area?.name || 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                    </svg>
                                                    {{ item.capacity }} guests
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <button @click="editListing(item)"
                                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Edit
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Empty State for Owner -->
                        <div v-else class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No properties found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding your first property listing.</p>
                            <div class="mt-6">
                                <button @click="addListing"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Listing
                                </button>
                            </div>
                        </div>
                    </div>
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
        let items = [...allItems.value] // Create a copy to avoid mutating the original

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

        // Sort items (now safe because we're sorting a copy)
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
