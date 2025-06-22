<script setup>
// uses (imports)
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import Navigation from '@/Components/app/Navigation.vue';
import SearchForm from '@/Components/app/SearchForm.vue';
import UserSettingsDropdown from '@/Components/app/UserSettingsDropdown.vue';
import { onMounted, onUnmounted } from 'vue';
import { emitter, FILE_UPLOAD_STARTED } from '@/event-bus';


const page = usePage();
const fileuploadForm = useForm({
    files: [],
    parent_id: null,
});

// refs
const showingNavigationDropdown = ref(false);
const dragOver = ref(false);

// props & emits
// (none in this file, but if you had defineProps/defineEmits, put them here)

// computed
// (none in this file, but if you had computed properties, put them here)

// methods
function handleDrop(event) {
    dragOver.value = false;
    const files = event.dataTransfer.files;
    console.log(files);
    if (!files.length) {
        return;
    }

    uploadfiles(files);
}

function onDragOver(event) {
    console.log(event);
    dragOver.value = true;
}

function onDragLeave(event) {
    console.log(event);
    dragOver.value = false
}

function uploadfiles(files) {
    console.log(page.props.folder);
    console.log(fileuploadForm);
    fileuploadForm.parent_id = page.props.folder.id
    fileuploadForm.files = files
    
    fileuploadForm.post(route('file.store'))
}

onMounted(() => {
    emitter.on(FILE_UPLOAD_STARTED, uploadfiles);
});

</script>

<template>
    <div class="flex w-full gap-4 bg-gray-50">
        <Navigation />
        
        <main @drop.prevent="handleDrop" @dragover.prevent="onDragOver" @dragleave.prevent="onDragLeave"
         class="flex flex-col flex-1 px-4 overflow-hidden" :class="dragOver ? 'dropzone' : ''">
            <template v-if="dragOver" class="absolute inset-0 bg-gray-500 opacity-50 text-white text-center">
                <div class="flex items-center justify-center h-full">
                    <p>Drop files here</p>
                </div>
            </template>
            <template v-else>
                <!-- Header Section -->
            <div class="flex items-center justify-between w-full py-4 border-b">
                <div class="flex-1 max-w-xl">
                    <SearchForm />
                </div>
                <div class="flex items-center gap-4 ml-4">
                    <UserSettingsDropdown />
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-auto py-6 px-4">
                <div class="rounded-lg bg-white p-6 shadow-md min-h-[520px]">
                        <slot />
                    </div>
                </div>
            </template>

        </main>
    </div>
</template>

<style>
/* Add smooth transitions for dropdowns */
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.2s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

.dropzone {
    background-color: #f0f0f0;
    position: relative;
    border: 2px dashed #ccc;
    border-radius: 10px;
    min-height: 520px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-size: 20px;
    color: #ccc;
    transition: all 0.3s ease;
    cursor: pointer;
    overflow: hidden;
    margin-bottom: 10px;
    margin-top: 10px;
    margin-left: 10px;
    margin-right: 10px;
    padding: 10px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
    overflow: hidden;
    margin-bottom: 10px;
    margin-top: 10px;
    margin-left: 10px;
    margin-right: 10px;
    padding: 10px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
    overflow: hidden;
    margin-bottom: 10px;
    margin-top: 10px;
    margin-left: 10px;
    margin-right: 10px;
    padding: 10px;  
}
</style>