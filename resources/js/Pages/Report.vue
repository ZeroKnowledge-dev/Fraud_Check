<template>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6 text-center">
                Report {{ validity === 0 ? 'Valid' : 'Fraud' }} {{ capitalizeFirst(type) }}
            </h1>

            <form @submit.prevent="submitReport">
                <div class="space-y-4 mb-6">
                    <div>
                        <h2 class="font-semibold mb-4">Entity Information</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input type="text" v-model="form.name"
                                    class="w-full p-2 border border-gray-300 rounded-md" required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" v-model="form.email"
                                    class="w-full p-2 border border-gray-300 rounded-md" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="tel" v-model="form.phone"
                                    class="w-full p-2 border border-gray-300 rounded-md" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                                <input type="url" v-model="form.url"
                                    class="w-full p-2 border border-gray-300 rounded-md" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input type="text" v-model="form.address"
                                    class="w-full p-2 border border-gray-300 rounded-md" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea v-model="form.description" rows="4"
                                    class="w-full p-2 border border-gray-300 rounded-md" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between pt-4 border-t">
                    <Link href="/" class="px-4 py-2 text-gray-700 hover:text-blue-500">Cancel</Link>
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                        :disabled="submitting">
                        {{ submitting ? 'Submitting...' : 'Submit Report' }}
                    </button>
                </div>
            </form>

            <div v-if="submitted" class="mt-6 bg-green-100 p-4 rounded-md">
                <h3 class="text-green-800 font-medium">Report Submitted Successfully!</h3>
                <p class="mt-2 text-green-700">
                    Thank you for your report. Your submission has been received and will be reviewed by our team.
                    Reference number: #{{ referenceNumber }}
                </p>
                <div class="mt-4">
                    <Link href="/" class="text-blue-500 hover:underline">Return to Home</Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    validity: String,
    type: String
});

const form = ref({
    name: '',
    email: '',
    phone: '',
    url: '',
    address: '',
    description: '',
    images: [],
    is_fraud: props.validity === '1',
    type: props.type,
});


const submitting = ref(false);
const submitted = ref(false);
const referenceNumber = ref('');

const submitReport = async () => {
    console.log(form.value);
    try {
        const response = await axios.post('/api/report', form.value);
        console.log(response);

    } catch (error) {
        console.log(error);
    }

};

const capitalizeFirst = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
};
</script>
