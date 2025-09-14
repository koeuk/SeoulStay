<template>
    <div class="min-h-screen" style="background: linear-gradient(135deg, #1a4a3a 0%, #0f2b24 100%); background-image: 
        linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px), 
        linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); 
        background-size: 50px 50px;">

        <!-- Navigation Bar -->
        <NavigationBar />

        <div class="p-4 mt-8">
            <div class="bg-white border rounded-lg border-black max-w-6xl mx-auto">
                <!-- Header -->
                <div class="border-b p-4">
                    <h1 class="text-xl font-bold">Seoul Stay - Add / Edit Listing</h1>
                </div>

                <!-- Tab Navigation -->
                <div class="border-b p-4">
                    <div class="flex space-x-1">
                        <button @click="activeTab = 'details'" :class="[
                            'px-4 py-2 border rounded-lg border-black',
                            activeTab === 'details' ? 'bg-gray-300' : 'bg-white'
                        ]">
                            Listing Details
                        </button>
                        <button @click="activeTab = 'amenities'" :class="[
                            'px-4 py-2 border rounded-lg border-black',
                            activeTab === 'amenities' ? 'bg-gray-300' : 'bg-white'
                        ]">
                            Amenities
                        </button>
                        <button @click="activeTab = 'attractions'" :class="[
                            'px-4 py-2 border rounded-lg border-black',
                            activeTab === 'attractions' ? 'bg-gray-300' : 'bg-white'
                        ]">
                            Distance to Attraction
                        </button>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="m-4 min-h-96">
                    <form @submit.prevent="submit">
                        <!-- Listing Details Tab -->
                        <div v-show="activeTab === 'details'" class="space-y-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Type:</label>
                                    <select v-model="form.item_type_id" class="w-full rounded-lg p-2"
                                        required>
                                        <option value="">Select Type</option>
                                        <option v-for="type in itemTypes" :key="type.id" :value="type.id" class="mt-3 d-flex rounded-lg bg-slate-200">
                                            {{ type.name }}
                                        </option>
                                    </select>
                                    <div v-if="form.errors.item_type_id" class="text-red-600 text-sm mt-1">
                                        {{ form.errors.item_type_id }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Area:</label>
                                    <select v-model="form.area_id" class="w-full rounded-lg border  p-2" required>
                                        <option value="">Select Area</option>
                                        <option v-for="area in areas" :key="area.id" :value="area.id" class="mt-3 d-flex rounded-lg bg-slate-200">
                                            {{ area.name }}
                                        </option>
                                    </select>
                                    <div v-if="form.errors.area_id" class="text-red-600 text-sm mt-1">
                                        {{ form.errors.area_id }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Title:</label>
                                    <input v-model="form.title" type="text" class="w-full border p-2 rounded-lg rounded-lg"
                                        required />
                                    <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">
                                        {{ form.errors.title }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Capacity:</label>
                                    <div class="relative">
                                        <input v-model.number="form.capacity" type="number" min="1"
                                            class="w-full border p-2 rounded-lg pr-8" required />
                                        <span class="absolute right-2 top-2">👥</span>
                                    </div>
                                    <div v-if="form.errors.capacity" class="text-red-600 text-sm mt-1">
                                        {{ form.errors.capacity }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Number of Beds:</label>
                                    <div class="relative">
                                        <input v-model.number="form.number_of_beds" type="number" min="1"
                                            class="w-full border p-2 rounded-lg pr-8" required />
                                        <span class="absolute right-2 top-2">🛏️</span>
                                    </div>
                                    <div v-if="form.errors.number_of_beds" class="text-red-600 text-sm mt-1">
                                        {{ form.errors.number_of_beds }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Number of Bedrooms:</label>
                                    <div class="relative">
                                        <input v-model.number="form.number_of_bedrooms" type="number" min="1"
                                            class="w-full border p-2 rounded-lg pr-8" required />
                                        <span class="absolute right-2 top-2">🏠</span>
                                    </div>
                                    <div v-if="form.errors.number_of_bedrooms" class="text-red-600 text-sm mt-1">
                                        {{ form.errors.number_of_bedrooms }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Number of Bathrooms:</label>
                                    <div class="relative">
                                        <input v-model.number="form.number_of_bathrooms" type="number" min="1"
                                            class="w-full border p-2 rounded-lg pr-8" required />
                                        <span class="absolute right-2 top-2">🚿</span>
                                    </div>
                                    <div v-if="form.errors.number_of_bathrooms" class="text-red-600 text-sm mt-1">
                                        {{ form.errors.number_of_bathrooms }}
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Approximate Address:</label>
                                <input v-model="form.approximate_address" type="text"
                                    class="w-full border p-2 rounded-lg" required />
                                <div v-if="form.errors.approximate_address" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.approximate_address }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Exact Address:</label>
                                <input v-model="form.exact_address" type="text" class="w-full border p-2 rounded-lg"
                                    required />
                                <div v-if="form.errors.exact_address" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.exact_address }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Description:</label>
                                <textarea v-model="form.description" class="w-full border p-2 rounded-lg h-24"
                                    required></textarea>
                                <div v-if="form.errors.description" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.description }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Host Rules:</label>
                                <textarea v-model="form.host_rules" class="w-full border p-2 rounded-lg h-20"
                                    placeholder="No smoking, No parties, Check-in after 3 PM, Check-out before 11 AM"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Reservation Time (Nights) -
                                        Minimum:</label>
                                    <div class="relative">
                                        <input v-model.number="form.minimum_nights" type="number" min="1"
                                            class="w-full border p-2 rounded-lg pr-8" required />
                                        <span class="absolute right-2 top-2">🌙</span>
                                    </div>
                                    <div v-if="form.errors.minimum_nights" class="text-red-600 text-sm mt-1">
                                        {{ form.errors.minimum_nights }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Maximum:</label>
                                    <div class="relative">
                                        <input v-model.number="form.maximum_nights" type="number" min="1"
                                            class="w-full border p-2 rounded-lg pr-8" required />
                                        <span class="absolute right-2 top-2">🌙</span>
                                    </div>
                                    <div v-if="form.errors.maximum_nights" class="text-red-600 text-sm mt-1">
                                        {{ form.errors.maximum_nights }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Amenities Tab -->
                        <div v-show="activeTab === 'amenities'" class="space-y-4">
                            <h3 class="text-lg font-bold mb-4">Choose Available Amenities:</h3>

                            <div class="border rounded-lg" >
                                <div class="bg-gray-200 rounded-t-lg p-2 flex justify-between items-center">
                                    <span class="font-medium">Amenity</span>
                                </div>
                                <div class="max-h-48 overflow-y-auto">
                                    <label v-for="amenity in amenities" :key="amenity.id"
                                        class="flex items-center justify-between p-2 border-t border-gray-300 hover:bg-gray-50 cursor-pointer"
                                        :class="{ 'bg-gray-100': form.amenities.includes(amenity.id) }">
                                        <span class="text-sm">{{ amenity.name }}</span>
                                        <input type="checkbox" :value="amenity.id" v-model="form.amenities"
                                            class="w-4 h-4" />
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Distance to Attractions Tab -->
                        <div v-show="activeTab === 'attractions'" class="space-y-4">
                            <h3 class="text-lg font-bold mb-4">Specify the distance from each close by attraction and
                                the time it takes to get to them:</h3>

                            <div class="overflow-x-auto rounded-lg">
                                <table class="w-full rounded-lg">
                                    <thead>
                                        <tr class="bg-gray-200 rounded-lg">
                                            <th class="border p-2 text-left rounded-t-lg">Attraction</th>
                                            <th class="border p-2 text-left">Area</th>
                                            <th class="border p-2 text-left">Distance (km)</th>
                                            <th class="border p-2 text-left">On Foot (minutes)</th>
                                            <th class="border p-2 text-left">By Car (minutes)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="rounded-lg">
                                        <tr v-for="attraction in attractions" :key="attraction.id" class="rounded-lg">
                                            <td class="border rounded-b-lg p-2">{{ attraction.name }}</td>
                                            <td class="border p-2">{{ attraction.area?.name }}</td>
                                            <td class="border p-2">
                                                <input v-model.number="getAttractionData(attraction.id).distance"
                                                    type="number" step="0.1" min="0"
                                                    class="w-full border rounded-lg border-gray-300 p-1"
                                                    @input="updateAttraction(attraction.id, 'distance', $event.target.value)" />
                                            </td>
                                            <td class="border p-2">
                                                <input
                                                    v-model.number="getAttractionData(attraction.id).duration_on_foot"
                                                    type="number" min="0" class="w-full border rounded-lg border-gray-300 p-1"
                                                    @input="updateAttraction(attraction.id, 'duration_on_foot', $event.target.value)" />
                                            </td>
                                            <td class="border p-2 rounded-b-lg">
                                                <input v-model.number="getAttractionData(attraction.id).duration_by_car"
                                                    type="number" min="0" class="w-full border rounded-lg border-gray-300 p-1"
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
                <div class="flex justify-end space-x-4 p-4 border-t">
                    <button @click="$inertia.visit('/dashboard')"
                        class="bg-red-600 text-white border rounded-lg px-6 py-2 hover:bg-red-700 mr-2"
                        v-if="activeTab === 'details' || activeTab === 'amenities'">
                        Cancel
                    </button>
                    <button @click="nextTab" class="bg-gray-300 border rounded-lg px-6 py-2 hover:bg-gray-400"
                        v-if="activeTab !== 'attractions'">
                        Next
                    </button>
                    <button @click="submit"
                        class="bg-blue-500 text-white border rounded-lg px-6 py-2 hover:bg-blue-600"
                        :disabled="form.processing">
                        {{ activeTab === 'attractions' ? 'Finish' : 'Save' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, reactive } from 'vue'
    import { useForm } from '@inertiajs/vue3'
    import NavigationBar from '@/Components/NavigationBar.vue'

    const props = defineProps({
        areas: Array,
        itemTypes: Array,
        amenities: Array,
        attractions: Array,
    })

    const activeTab = ref('details')

    const form = useForm({
        title: '',
        item_type_id: '',
        area_id: '',
        capacity: 1,
        number_of_beds: 1,
        number_of_bedrooms: 1,
        number_of_bathrooms: 1,
        approximate_address: '',
        exact_address: '',
        description: '',
        host_rules: '',
        minimum_nights: 1,
        maximum_nights: 30,
        amenities: [],
        attractions: [],
    })

    const attractionDistances = reactive({})

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

        form.post(route('items.store'))
    }
</script>