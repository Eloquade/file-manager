<script setup>
// uses (imports)
import { MenuItem } from '@headlessui/vue';
import { emitter, FILE_UPLOAD_STARTED } from '../../event-bus';

// refs
// (none in this file, but if you had refs, put them here)

// props & emits
// (none in this file, but if you had defineProps/defineEmits, put them here)

// computed
// (none in this file, but if you had computed properties, put them here)

// methods
function onChange(event) {
    const files = event.target.files;
    emitter.emit(FILE_UPLOAD_STARTED, files);
}
</script>

<template>
  <MenuItem v-slot="{ active }">
    <a
      href="#"
      :class="[
        active ? 'bg-blue-500 text-white' : 'text-gray-900',
        'group flex w-full items-center rounded-md px-3 py-2 text-sm relative'
      ]"
    >
      Upload Folder
      <input @change="onChange" type="file" class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer" multiple
       directory webkitdirectory mozdirectory />
    </a>
  </MenuItem>
</template>
