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
                        <h1 class="text-3xl font-bold text-gray-900">Edit Items</h1>
                        <p class="mt-2 text-gray-600">Update your Items listing information</p>
                    </div>
                    <img src="/seoul-station-logo.svg" alt="Seoul Station Logo" class="h-12 w-auto">
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">items Information</h2>
                    <p class="text-sm text-gray-600 mt-1">Update the details below to modify your Items listing</p>
                </div>

                <!-- Tab Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button @click="activeTab = 'details'" 
                            :class="[
                                'py-4 px-1 border-b-2 font-medium text-sm transition-colors',
                                activeTab === 'details' 
                                    ? 'border-blue-500 text-blue-600' 
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                            ]">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span>Details</span>
                            </div>
                        </button>
                        <button @click="activeTab = 'amenities'" 
                            :class="[
                                'py-4 px-1 border-b-2 font-medium text-sm transition-colors',
                                activeTab === 'amenities' 
                                    ? 'border-blue-500 text-blue-600' 
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                            ]">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                                <span>Amenities</span>
                            </div>
                        </button>
                        <button @click="activeTab = 'attractions'" 
                            :class="[
                                'py-4 px-1 border-b-2 font-medium text-sm transition-colors',
                                activeTab === 'attractions' 
                                    ? 'border-blue-500 text-blue-600' 
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                            ]">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Attractions</span>
                            </div>
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <form @submit.prevent="submit">
                        <!-- Listing Details Tab -->
                        <div v-show="activeTab === 'details'" class="space-y-6">
                            <!-- Basic Information -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"> Type *</label>
                                    <select v-model="form.item_type_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required>
                                        <option value="">Select Type</option>
                                        <option v-for="type in itemTypes" :key="type.id" :value="type.id">
                                            {{ type.name }}
                                        </option>
                                    </select>
                                    <div v-if="form.errors.item_type_id" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.item_type_id }}
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
                                    <label class="block text-sm font-medium text-gray-700 mb-2"> Title *</label>
                                    <input v-model="form.title" type="text" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Enter title"
                                        required />
                                    <div v-if="form.errors.title" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.title }}
                                    </div>
                                </div>
                            </div>

                            <!-- Property Details -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Guest Capacity *</label>
                                    <div class="relative">
                                        <input v-model.number="form.capacity" type="number" min="1"
                                            class="block w-full px-3 py-2 pl-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="2"
                                            required />
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div v-if="form.errors.capacity" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.capacity }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Beds *</label>
                                    <div class="relative">
                                        <input v-model.number="form.number_of_beds" type="number" min="1"
                                            class="block w-full px-3 py-2 pl-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="2"
                                            required />
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div v-if="form.errors.number_of_beds" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.number_of_beds }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Bedrooms *</label>
                                    <div class="relative">
                                        <input v-model.number="form.number_of_bedrooms" type="number" min="1"
                                            class="block w-full px-3 py-2 pl-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="1"
                                            required />
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div v-if="form.errors.number_of_bedrooms" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.number_of_bedrooms }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Bathrooms *</label>
                                    <div class="relative">
                                        <input v-model.number="form.number_of_bathrooms" type="number" min="1"
                                            class="block w-full px-3 py-2 pl-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="1"
                                            required />
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div v-if="form.errors.number_of_bathrooms" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.number_of_bathrooms }}
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Approximate Address *</label>
                                    <input v-model="form.approximate_address" type="text"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="e.g., Gangnam-gu, Seoul"
                                        required />
                                    <div v-if="form.errors.approximate_address" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.approximate_address }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Exact Address *</label>
                                    <input v-model="form.exact_address" type="text" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Full street address"
                                        required />
                                    <div v-if="form.errors.exact_address" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.exact_address }}
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                                <textarea v-model="form.description" rows="4"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Describe your item, its features, and what makes it special..."
                                    required></textarea>
                                <div v-if="form.errors.description" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.description }}
                                </div>
                            </div>

                            <!-- Host Rules -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">House Rules</label>
                                <textarea v-model="form.host_rules" rows="3"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="No smoking, No parties, Check-in after 3 PM, Check-out before 11 AM"></textarea>
                                <p class="mt-1 text-sm text-gray-500">Optional: Specify any house rules for your guests</p>
                            </div>

                            <!-- Stay Duration -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Stay (Nights) *</label>
                                    <div class="relative">
                                        <input v-model.number="form.minimum_nights" type="number" min="1"
                                            class="block w-full px-3 py-2 pl-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="1"
                                            required />
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div v-if="form.errors.minimum_nights" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.minimum_nights }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Maximum Stay (Nights) *</label>
                                    <div class="relative">
                                        <input v-model.number="form.maximum_nights" type="number" min="1"
                                            class="block w-full px-3 py-2 pl-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="30"
                                            required />
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div v-if="form.errors.maximum_nights" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.maximum_nights }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Amenities Tab -->
                        <div v-show="activeTab === 'amenities'" class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Available Amenities</h3>
                                    <p class="text-sm text-gray-600">Select all amenities that are available in your item</p>
                                </div>
                                <Link :href="route('amenities.index')"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Manage Amenities
                                </Link>
                            </div>

                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700">Amenity</span>
                                        <span class="text-sm font-medium text-gray-700">Available</span>
                                    </div>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <div v-for="amenity in amenities" :key="amenity.id"
                                        class="flex items-center justify-between px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer"
                                        :class="{ 'bg-blue-50': form.amenities.includes(amenity.id) }">
                                        <span class="text-sm text-gray-900">{{ amenity.name }}</span>
                                        <input type="checkbox" :value="amenity.id" v-model="form.amenities"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Distance to Attractions Tab -->
                        <div v-show="activeTab === 'attractions'" class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Nearby Attractions</h3>
                                    <p class="text-sm text-gray-600">Specify the distance and travel time to nearby attractions</p>
                                </div>
                                <Link :href="route('attractions.index')"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Manage Attractions
                                </Link>
                            </div>

                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Attraction
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Area
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Distance (km)
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Walking (min)
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Driving (min)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="attraction in attractions" :key="attraction.id">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ attraction.name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ attraction.area?.name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input v-model.number="getAttractionData(attraction.id).distance"
                                                    type="number" step="0.1" min="0"
                                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                    @input="updateAttraction(attraction.id, 'distance', $event.target.value)" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input v-model.number="getAttractionData(attraction.id).duration_on_foot"
                                                    type="number" min="0" 
                                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                    @input="updateAttraction(attraction.id, 'duration_on_foot', $event.target.value)" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input v-model.number="getAttractionData(attraction.id).duration_by_car"
                                                    type="number" min="0" 
                                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                    @input="updateAttraction(attraction.id, 'duration_by_car', $event.target.value)" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
                    <div class="flex space-x-3">
                        <button @click="$inertia.visit('/dashboard')"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </button>
                    </div>
                    <div class="flex space-x-3">
                        <button @click="nextTab" 
                            v-if="activeTab !== 'attractions'"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Next
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        <button @click="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                            <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ activeTab === 'attractions' ? 'Update Item' : 'Save & Continue' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, reactive, onMounted } from 'vue'
    import { useForm, Link } from '@inertiajs/vue3'
    import NavigationBar from '@/Components/NavigationBar.vue'

    const props = defineProps({
        item: Object,
        areas: Array,
        itemTypes: Array,
        amenities: Array,
        attractions: Array,
    })

    const activeTab = ref('details')

    const form = useForm({
        title: props.item.title || '',
        item_type_id: props.item.item_type_id || '',
        area_id: props.item.area_id || '',
        capacity: props.item.capacity || 1,
        number_of_beds: props.item.number_of_beds || 1,
        number_of_bedrooms: props.item.number_of_bedrooms || 1,
        number_of_bathrooms: props.item.number_of_bathrooms || 1,
        approximate_address: props.item.approximate_address || '',
        exact_address: props.item.exact_address || '',
        description: props.item.description || '',
        host_rules: props.item.host_rules || '',
        minimum_nights: props.item.minimum_nights || 1,
        maximum_nights: props.item.maximum_nights || 30,
        amenities: props.item.amenities?.map(a => a.id) || [],
        attractions: [],
    })

    const attractionDistances = reactive({})

    // Initialize existing attraction data
    onMounted(() => {
        if (props.item.attractions) {
            props.item.attractions.forEach(attraction => {
                attractionDistances[attraction.id] = {
                    id: attraction.id,
                    distance: attraction.pivot?.distance || 0,
                    duration_on_foot: attraction.pivot?.duration_on_foot || 0,
                    duration_by_car: attraction.pivot?.duration_by_car || 0,
                }
            })
        }
    })

    const getAttractionData = (attractionId) => {
        if (!attractionDistances[attractionId]) {
            attractionDistances[attractionId] = {
                id: attractionId,
                distance: 0,
                duration_on_foot: 0,
                duration_by_car: 0,
            }
        }
        return attractionDistances[attractionId]
    }

    const updateAttraction = (attractionId, field, value) => {
        const data = getAttractionData(attractionId)
        data[field] = parseFloat(value) || 0

        // Auto-calculate times based on distance if not manually set
        if (field === 'distance') {
            if (!data.duration_on_foot) {
                data.duration_on_foot = Math.round(data.distance * 15) // 15 min per km walking
            }
            if (!data.duration_by_car) {
                data.duration_by_car = Math.round(data.distance * 3) // 3 min per km driving
            }
        }
    }

    const nextTab = () => {
        if (activeTab.value === 'details') {
            activeTab.value = 'amenities'
        } else if (activeTab.value === 'amenities') {
            activeTab.value = 'attractions'
        }
    }

    const submit = () => {
        // Convert attraction distances to array format
        form.attractions = Object.values(attractionDistances).filter(attr =>
            attr.distance > 0 || attr.duration_on_foot > 0 || attr.duration_by_car > 0
        )

        form.put(route('items.update', props.item.uuid))
    }
</script>