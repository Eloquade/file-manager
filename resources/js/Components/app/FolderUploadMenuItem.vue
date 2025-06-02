<script setup>
import { MenuItem } from '@headlessui/vue';
</script>

<template>
  <MenuItem v-slot="{ active }">
    <a
      href="#"
      :class="[
        active ? 'bg-blue-500 text-white' : 'text-gray-900',
        'group flex w-full items-center rounded-md px-3 py-2 text-sm'
      ]"
    >
    Upload Folder
    </a>
  </MenuItem>
</template>
