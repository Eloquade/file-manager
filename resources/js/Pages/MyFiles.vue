<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const { files, folder, ancestors } = defineProps({
    files: Object,
    folder: Object,
    ancestors: Array,
});

function openFolder(file) {
    if (file.is_folder) {
        router.visit(route('myFiles', { folder: file.path }));
    }
}

function deleteFile(id) {
    if (confirm('Are you sure you want to delete this file?')) {
        router.delete(route('myFiles.destroy', { id: id }));
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 mb-6 bg-white p-4 rounded-lg shadow-sm">
            <ol class="flex items-center gap-2 text-sm">
                <li v-for="ancestor in ancestors.data" :key="ancestor.id" class="inline-flex items-center">
                    <Link v-if="!ancestor.parent_id" :href="route('myFiles')" 
                        class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white font-medium transition duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Root
                    </Link>
                    <span class="text-gray-500 mx-2">/</span>
                    <Link :href="route('myFiles', { folder: ancestor.path })" 
                        class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white font-medium transition duration-150">
                        <svg v-if="ancestor.parent_id" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        {{ ancestor.name }}
                    </Link>
                </li>
            </ol>
        </nav>

        <!-- File Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Modified</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="file in files.data"
                        :key="file.id"
                        :class="file.is_folder ? 'hover:bg-blue-50' : 'hover:bg-gray-50'">
                        <td class="px-6 py-4 whitespace-nowrap" @click="file.is_folder && openFolder(file)">
                            <div class="flex items-center">
                                <!-- Folder Icon -->
                                <svg v-if="file.is_folder" class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                                <!-- File Icon -->
                                <svg v-else class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span :class="file.is_folder ? 'font-medium text-blue-600 cursor-pointer' : 'text-gray-900'">{{ file.name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ file.owner }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ file.size }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ file.updated_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <button 
                                v-if="file.id === 1"
                                @click="deleteFile(file.id)"
                                class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Empty State -->
            <div v-if="!files.data.length" class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No files</h3>
                <p class="mt-1 text-sm text-gray-500">This folder is empty.</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.transition {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}
</style>
