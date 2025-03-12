<template>
    <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <!-- Back Navigation -->
            <div class="mb-6 max-w-2xl mx-auto">
                <Link href="/" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
                </Link>
            </div>

            <!-- Search Header Card -->
            <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-center mb-4">
                        <div class="h-10 w-10 rounded-full flex items-center justify-center mr-3" :class="{
                            'bg-green-100 text-green-600': validity == 0,
                            'bg-red-100 text-red-600': validity == 1
                        }">
                            <svg v-if="validity == 0" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            Search {{ validity == 0 ? 'Valid' : 'Reported Fraudulent' }} {{ capitalizeFirst(type) }}
                        </h1>
                    </div>

                    <div class="relative">
                        <input type="text" v-model="searchQuery"
                            placeholder="Enter name, ID, or other identifying information..."
                            class="w-full p-4 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow" />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <button v-if="searchQuery" @click="searchQuery = ''"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-gray-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">
                        Search for {{ validity == 0 ? 'legitimate' : 'reported fraudulent' }} {{ type === 'person' ?
                            'individuals' : 'companies' }}
                        in our database.
                    </p>
                </div>
            </div>

            <!-- Results Count -->
            <div class="max-w-2xl mx-auto mb-4 px-2">
                <p class="text-sm text-gray-600">
                    {{ filteredResults.length }} result{{ filteredResults.length !== 1 ? 's' : '' }}
                    {{ searchQuery ? `for "${searchQuery}"` : '' }}
                </p>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-8 text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto mb-4"></div>
                <p class="text-gray-600">Searching database...</p>
            </div>

            <!-- No Results State -->
            <div v-else-if="filteredResults.length === 0"
                class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-8 text-center">
                <div class="h-20 w-20 mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No results found</h3>
                <p class="text-gray-600 mb-4">
                    We couldn't find any matches for "{{ searchQuery }}". Try different keywords or check your spelling.
                </p>
                <button @click="searchQuery = ''"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Clear Search
                </button>
            </div>

            <!-- Search Results as Facebook-like Cards -->
            <div v-else class="max-w-2xl mx-auto space-y-4">
                <transition-group name="fade" tag="div" class="space-y-4">
                    <div v-for="(result, index) in filteredResults" :key="index"
                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <!-- Card Header -->
                        <div class="p-4 border-b border-gray-100 flex items-center">
                            <div
                                class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-3">
                                <svg v-if="type === 'person'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-semibold text-lg text-gray-800">{{ result.name || 'Unnamed' }}</h2>
                                <p class="text-sm text-gray-500">{{ formateDate(result.created_at) }}</p>
                            </div>
                            <div class="ml-auto">
                                <span class="px-3 py-1 rounded-full text-sm" :class="{
                                    'bg-green-100 text-green-700': validity == 0,
                                    'bg-red-100 text-red-700': validity == 1
                                }">
                                    {{ validity == 0 ? 'Verified' : 'Reported' }}
                                </span>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="p-4">
                            <!-- Description -->
                            <p v-if="result.description" class="text-gray-700 mb-4">{{ result.description }}</p>
                            <!-- Image Gallery -->
                            <div v-if="JSON.parse(result.images) && JSON.parse(result.images).length" class="mb-4">
                                <div class="grid grid-cols-2 gap-2">
                                    <div v-for="(image, imageIndex) in JSON.parse(result.images).slice(0, 4)"
                                        :key="imageIndex" class="relative h-40 bg-gray-100 rounded overflow-hidden">
                                        <img :src="`/storage/${image}`" :alt="`Image ${imageIndex + 1}`"
                                            class="w-full h-full object-cover transition-transform hover:scale-105" />
                                        <!-- Show "+X more" on the last visible image if there are more images -->
                                        <div v-if="imageIndex === 3 && JSON.parse(result.images).length > 4"
                                            class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-white font-bold">
                                            +{{ JSON.parse(result.images).length - 4 }} more
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Details Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div v-if="result.email" class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm text-gray-700 truncate">{{ result.email }}</span>
                                </div>
                                <div v-if="result.phone" class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="text-sm text-gray-700 truncate">{{ result.phone }}</span>
                                </div>
                                <div v-if="result.url" class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    <span class="text-sm text-gray-700 truncate">{{ result.url }}</span>
                                </div>
                                <div v-if="result.address" class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-700 truncate">{{ result.address }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Verify Count -->
                        <div>
                            <p class="text-sm text-gray-600">{{ result.verify_count }}</p>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex justify-between">
                            <button @click="handleVerify(result.id)"
                                class="flex items-center hover:text-green-600 transition-colors"
                                :class="`{{ verifyDone ? 'text-green-600' : 'text-gray-600' }}`">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                Verify
                            </button>
                        </div>
                    </div>
                </transition-group>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    validity: {
        type: [String, Number],
        required: true
    },
    type: {
        type: String,
        required: true
    },
    data: {
        type: Array,
        required: true
    }
});

const searchQuery = ref('');
const loading = ref(true);
const verifyDone = ref(false);

// Simulate loading state
onMounted(() => {
    setTimeout(() => {
        loading.value = false;
    }, 800);
});

const filteredResults = computed(() => {
    if (!searchQuery.value.trim()) return props.data;

    const query = searchQuery.value.toLowerCase().trim();
    return props.data.filter(item => {
        // Handle cases where some properties might be undefined
        return (
            (item.name && item.name.toLowerCase().includes(query)) ||
            (item.id && item.id.toString().includes(query)) ||
            (item.email && item.email.toLowerCase().includes(query)) ||
            (item.phone && item.phone.includes(query)) ||
            (item.url && item.url.toLowerCase().includes(query)) ||
            (item.address && item.address.toLowerCase().includes(query))
        );
    });
});

const capitalizeFirst = (string) => {
    if (!string) return '';
    return string.charAt(0).toUpperCase() + string.slice(1);
};

const handleVerify = async (id) => {
    if (verifyDone.value) {
        const response = await axios.post('/api/verify-down', {
            id: id
        });
        verifyDone.value = false;
    } else {
        const response = await axios.post('/api/verify-up', {
            id: id
        });
        verifyDone.value = true;
    }
};

const formateDate = (value) => {
    const date = new Date(value);

    // Get month name
    const options = { month: "long" };
    const month = new Intl.DateTimeFormat("en-US", options).format(date);

    // Get day and time
    const day = date.getDate();
    const hours = date.getHours() % 12 || 12; // Convert to 12-hour format
    const minutes = date.getMinutes();
    const amPm = date.getHours() >= 12 ? "PM" : "AM";

    // Format the string
    return `${month} ${day} at ${hours}:${minutes.toString().padStart(2, "0")} ${amPm}`;
}
</script>

<style scoped>
/* Smooth transition for items */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}

/* Handle transition-group movement */
.fade-move {
    transition: transform 0.4s ease;
}
</style>
