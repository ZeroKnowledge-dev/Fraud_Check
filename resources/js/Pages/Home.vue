<template>
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
        <!-- Responsive Navbar -->
        <nav class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white py-4 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-6">
                <h1 class="text-2xl font-bold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Fraud Checker
                </h1>
                <div class="flex space-x-4">
                    <a v-if="canLogin" :href="route('login')"
                        class="px-3 py-1 rounded hover:bg-blue-600 transition-all">Login</a>
                    <a v-if="canRegister" :href="route('register')"
                        class="px-3 py-1 bg-white text-blue-700 rounded hover:bg-gray-100 transition-all">Register</a>
                </div>
            </div>
        </nav>

        <div class="container mx-auto px-4 py-12">
            <!-- Improved App Introduction -->
            <div class="mb-12 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-700">Verify &
                        Protect</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-6">
                    Stay one step ahead of fraud. Our platform helps you instantly verify legitimate entities
                    and report suspicious activities to protect yourself and others.
                </p>
                <div class="flex flex-wrap justify-center gap-4 text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Fast Verification
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Community Reports
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Data Protection
                    </div>
                </div>
            </div>

            <!-- Steps Navigation with Improved Animation -->
            <div
                class="max-w-md mx-auto bg-white rounded-xl shadow-xl overflow-hidden transition-all duration-300 transform hover:scale-102">
                <div class="px-8 pt-8 pb-6 border-b border-gray-100">
                    <h2 class="text-2xl font-semibold text-center text-gray-800">
                        {{
                            currentStep === 1 ? 'How can we help you today?' :
                                currentStep === 2 ? 'What would you like to check?' :
                                    'Select entity type'
                        }}
                    </h2>
                </div>

                <div class="p-8">
                    <transition-group name="slide-fade" mode="out-in" tag="div" class="relative">
                        <div v-if="currentStep === 1" key="step1" class="step-content">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <button @click="selectAction('search')"
                                    class="p-6 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search
                                </button>
                                <button @click="selectAction('report')"
                                    class="p-6 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg hover:shadow-lg flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Report
                                </button>
                            </div>
                        </div>

                        <div v-if="currentStep === 2" key="step2" class="step-content">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <button @click="selectValidity(0)"
                                    class="p-6 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Valid
                                </button>
                                <button @click="selectValidity(1)"
                                    class="p-6 bg-gradient-to-br from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Fraud
                                </button>
                            </div>
                            <button @click="goBack(1)"
                                class="mt-6 w-full py-2 text-gray-600 hover:text-blue-600 flex items-center justify-center transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Back
                            </button>
                        </div>

                        <div v-if="currentStep === 3" key="step3" class="step-content">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <button @click="selectType('person')"
                                    class="p-6 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Person
                                </button>
                                <button @click="selectType('company')"
                                    class="p-6 bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg hover:shadow-lg flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Company
                                </button>
                            </div>
                            <button @click="goBack(2)"
                                class="mt-6 w-full py-2 text-gray-600 hover:text-blue-600 flex items-center justify-center transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Back
                            </button>
                        </div>
                    </transition-group>
                </div>

                <!-- Enhanced Progress Indicator -->
                <div class="px-8 py-6 bg-gray-50">
                    <div class="relative">
                        <div class="overflow-hidden h-2 mb-2 text-xs flex rounded bg-gray-200">
                            <div :style="{ width: `${(currentStep / 3) * 100}%` }"
                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500 ease-in-out">
                            </div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <div class="flex flex-col items-center">
                                <div :class="['w-6 h-6 flex items-center justify-center rounded-full transition-all',
                                    currentStep >= 1 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-500']">1</div>
                                <span class="mt-1">Action</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div :class="['w-6 h-6 flex items-center justify-center rounded-full transition-all',
                                    currentStep >= 2 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-500']">2</div>
                                <span class="mt-1">Status</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div :class="['w-6 h-6 flex items-center justify-center rounded-full transition-all',
                                    currentStep >= 3 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-500']">3</div>
                                <span class="mt-1">Type</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean
});

const currentStep = ref(1);
const selectedAction = ref(null);
const selectedValidity = ref(null);
const selectedType = ref(null);

const selectAction = (action) => {
    selectedAction.value = action;
    setTimeout(() => {
        currentStep.value = 2;
    }, 150); // Slight delay for better animation effect
};

const selectValidity = (validity) => {
    selectedValidity.value = validity;
    setTimeout(() => {
        currentStep.value = 3;
    }, 150); // Slight delay for better animation effect
};

const selectType = (type) => {
    selectedType.value = type;
    navigateToFinalPage();
};

const goBack = (step) => {
    setTimeout(() => {
        currentStep.value = step;
    }, 150); // Slight delay for better animation effect
};

const navigateToFinalPage = () => {
    // Add a loading state or transition here if desired
    setTimeout(() => {
        const route = `/${selectedAction.value}/${selectedValidity.value}/${selectedType.value}`;
        window.location.href = route;
    }, 300);
};
</script>

<style>
/* Step transition animations */
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.slide-fade-enter-from {
    transform: translateX(30px);
    opacity: 0;
}

.slide-fade-leave-to {
    transform: translateX(-30px);
    opacity: 0;
}

/* Make sure content doesn't jump around during transitions */
.step-content {
    min-height: 160px;
    display: flex;
    flex-direction: column;
}

/* Custom hover scale for cards */
.hover\:scale-102:hover {
    transform: scale(1.02);
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .step-content {
        min-height: 240px;
    }
}
</style>
