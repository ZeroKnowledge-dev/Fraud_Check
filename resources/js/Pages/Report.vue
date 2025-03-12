<template>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6 text-center">
                Report {{ validity === '0' ? 'Valid' : 'Fraud' }} {{ capitalizeFirst(type) }}
            </h1>

            <form @submit.prevent="submitForm">
                <div class="space-y-4 mb-6">
                    <div>
                        <h2 class="font-semibold mb-4">Entity Information</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input type="text" v-model="form.name"
                                    class="w-full p-2 border border-gray-300 rounded-md" required />
                                <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" v-model="form.email"
                                    class="w-full p-2 border border-gray-300 rounded-md" />
                                <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="tel" v-model="form.phone"
                                    class="w-full p-2 border border-gray-300 rounded-md" />
                                <div v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                                <input type="url" v-model="form.url"
                                    class="w-full p-2 border border-gray-300 rounded-md" />
                                <div v-if="form.errors.url" class="text-red-500 text-sm mt-1">{{ form.errors.url }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input type="text" v-model="form.address"
                                    class="w-full p-2 border border-gray-300 rounded-md" />
                                <div v-if="form.errors.address" class="text-red-500 text-sm mt-1">{{ form.errors.address
                                    }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea v-model="form.description" rows="4"
                                    class="w-full p-2 border border-gray-300 rounded-md" required></textarea>
                                <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{
                                    form.errors.description }}</div>
                            </div>

                            <!-- Multiple image upload component -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Images</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-md p-4 text-center cursor-pointer hover:bg-gray-50"
                                    @click="$refs.fileInput.click()" @dragover.prevent @drop.prevent="handleFileDrop">
                                    <input ref="fileInput" type="file" multiple accept="image/*" class="hidden"
                                        @change="handleFileSelect" />
                                    <div class="space-y-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="text-sm text-gray-600">
                                            Drag and drop images here, or click to select files
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            (PNG, JPG, JPEG up to 5MB each)
                                        </p>
                                    </div>
                                </div>
                                <div v-if="form.errors.images" class="text-red-500 text-sm mt-1">{{ form.errors.images
                                    }}</div>

                                <!-- Image preview section -->
                                <div v-if="imagePreviewUrls.length > 0" class="mt-3 grid grid-cols-3 gap-2">
                                    <div v-for="(url, index) in imagePreviewUrls" :key="index" class="relative">
                                        <img :src="url" class="h-24 w-full object-cover rounded-md" />
                                        <button @click.prevent="removeImage(index)"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 text-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between pt-4 border-t">
                    <Link href="/" class="px-4 py-2 text-gray-700 hover:text-blue-500">Cancel</Link>
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                        :disabled="form.processing">
                        {{ form.processing ? 'Submitting...' : 'Submit Report' }}
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
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    validity: {
        type: String,
        required: true
    },
    type: {
        type: String,
        required: true
    }
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    url: '',
    address: '',
    description: '',
    images: null, // Change from [] to null
    is_fraud: props.validity === '1',
    type: props.type,
});

const submitted = ref(false);
const referenceNumber = ref('');
const imagePreviewUrls = ref([]);
const fileInput = ref(null);

// Submit form using Inertia
const submitForm = async function () {
    console.log(form);

    // Important: Files must be attached properly to match controller expectations
    await form.post('/api/report', {
        forceFormData: true, // Force using FormData for file uploads
        onSuccess: (response) => {
            submitted.value = true;
            console.log(response);

            // Use the entity ID from the response if available, or generate random ID
            if (response?.data?.id) {
                referenceNumber.value = response.data.id.toString();
            } else {
                referenceNumber.value = Math.random().toString(36).substring(2, 10).toUpperCase();
            }

            // Reset form
            form.reset('name', 'email', 'phone', 'url', 'address', 'description');
            form.images = []; // Reset images array
            imagePreviewUrls.value = [];
        },
    });
}

const handleFileSelect = (event) => {
    const files = Array.from(event.target.files);
    addFilesToForm(files);
};

const handleFileDrop = (event) => {
    const files = Array.from(event.dataTransfer.files).filter(file => file.type.startsWith('image/'));
    addFilesToForm(files);
};

const addFilesToForm = (files) => {
    const validFiles = files.filter(file => file.type.startsWith('image/') && file.size <= 5 * 1024 * 1024);

    if (validFiles.length > 0) {
        form.images = validFiles; // Store the files directly
    }

    validFiles.forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreviewUrls.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    });
};

const removeImage = (index) => {
    imagePreviewUrls.value.splice(index, 1);

    // Create a new array to ensure reactivity
    const newImages = [...form.images];
    newImages.splice(index, 1);
    form.images = newImages;
};

const capitalizeFirst = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
};
</script>
