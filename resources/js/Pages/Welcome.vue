<template>

    <Head title="Fraud Check" />
    <div class="min-h-screen bg-gray-100 p-4 md:p-8" style="background-color: #f5f9fc;">
        <!-- Header -->
        <header class="max-w-6xl mx-auto mb-8">
            <h1 class="text-3xl font-bold text-center" style="color: #13293d;">Fraud Check System</h1>
            <p class="text-center text-gray-600 mt-2">Verify emails, phone numbers, and facebook accounts against our
                database</p>
        </header>

        <!-- Search Input -->
        <div class="max-w-xl mx-auto bg-white p-6 md:p-8 rounded-xl shadow-lg">
            <div class="flex items-center justify-center mb-6">
                <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #1b98e0;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>

            <div class="relative">
                <input v-model="searchQuery" @input="searchFraudster" type="text"
                    placeholder="Enter email, phone number or facebook link..."
                    class="w-full p-4 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                    :style="{ 'focus:ring-color': '#1b98e0' }" />
                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="max-w-6xl mx-auto mt-8">
            <!-- Loading Indicator -->
            <div v-if="isLoading" class="flex justify-center my-12">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2" style="border-color: #1b98e0;">
                </div>
            </div>

            <!-- Results Count -->
            <div v-if="fraudsters.length > 0" class="mb-4 text-gray-600 px-4">
                Found {{ fraudsters.length }} result{{ fraudsters.length !== 1 ? 's' : '' }}
            </div>

            <!-- Search Result Cards -->
            <div v-if="fraudsters.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
                <div v-for="(fraudsterItem, index) in fraudsters" :key="index"
                    class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-semibold" style="color: #13293d;">{{ fraudsterItem.name }}</h2>
                        <span class="px-3 py-1 rounded-full text-sm font-medium" :style="{
                            backgroundColor: fraudsterItem.status === 'Fraud' ? '#ffebee' : '#e3f2fd',
                            color: fraudsterItem.status === 'Fraud' ? '#c62828' : '#0277bd'
                        }">
                            {{ fraudsterItem.status }}
                        </span>
                    </div>

                    <div class="space-y-2">
                        <!-- Contact Info -->
                        <div v-if="fraudsterItem.email" class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" style="color: #247ba0;"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-700 break-words">{{ fraudsterItem.email }}</span>
                        </div>

                        <div v-if="fraudsterItem.phone" class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" style="color: #247ba0;"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-gray-700">{{ fraudsterItem.phone }}</span>
                        </div>

                        <div v-if="fraudsterItem.address" class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" style="color: #247ba0;"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-gray-700">{{ fraudsterItem.address }}</span>
                        </div>

                        <div v-if="fraudsterItem.url" class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" style="color: #247ba0;"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            <a :href="fraudsterItem.url"
                                class="text-gray-700 hover:underline break-words overflow-hidden"
                                style="color: #006494;">
                                {{ fraudsterItem.url }}
                            </a>
                        </div>
                    </div>

                    <!-- Description -->
                    <div v-if="fraudsterItem.description" class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-gray-700 text-sm">{{ fraudsterItem.description }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex gap-2">
                        <button
                            class="flex-1 py-2 px-4 rounded-lg text-white text-sm font-medium transition-colors duration-300 bg-[#006494] hover:bg-[#13293d]">
                            More Details
                        </button>
                        <button class="flex items-center justify-center p-2 rounded-lg transition-colors duration-300"
                            style="background-color: #f0f4f8; color: #247ba0;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- No Results Message -->
            <div v-if="errorMessage" class="mt-8 bg-white p-8 rounded-xl shadow-md text-center mx-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-semibold mb-2" style="color: #13293d;">No Results Found</h3>
                <p class="text-gray-600">{{ errorMessage }}</p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-12 text-center text-gray-500 text-sm">
            <p>© 2025 Fraud Check System. All rights reserved.</p>
        </footer>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const searchQuery = ref('');
const fraudsters = ref([]);
const errorMessage = ref('');
const isLoading = ref(false);

// Function to search for fraudsters or legitimate users
const searchFraudster = async () => {
    // If the search query is empty, clear the results and error messages
    if (!searchQuery.value) {
        fraudsters.value = [];
        errorMessage.value = '';
        return;
    }

    // Set loading state
    isLoading.value = true;
    errorMessage.value = '';

    try {
        // Debounce the API call (wait 300ms after typing stops)
        await new Promise(resolve => setTimeout(resolve, 300));

        // Send the request to the backend
        const response = await axios.post('/api/check-fraud-or-legit', {
            data: searchQuery.value
        });

        // Check if data is returned and it's an array of results
        if (response.data.status === 'found' && Array.isArray(response.data.data)) {
            fraudsters.value = response.data.data;
        } else {
            fraudsters.value = [];
            errorMessage.value = 'Unknown status. Please try a different search term.';
        }
    } catch (error) {
        // Handle error cases
        if (error.response && error.response.status === 404) {
            errorMessage.value = 'No fraudster found with that email or phone number.';
        } else {
            errorMessage.value = 'An error occurred. Please try again later.';
        }
        fraudsters.value = [];
    } finally {
        // End loading state
        isLoading.value = false;
    }
};
</script>

<style scoped>
/* Base Styles */
body {
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Custom focus styles */
input:focus {
    border-color: #1b98e0;
}

/* Custom transition for buttons */
button {
    transition: all 0.2s ease;
}

button:hover {
    transform: translateY(-1px);
}

button:active {
    transform: translateY(0);
}
</style>
