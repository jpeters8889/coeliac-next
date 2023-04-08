<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps({
  label: {
    type: String,
    required: true,
  },
  href: {
    type: String,
    required: false,
    default: null,
  },
});
</script>

<template>
  <Link
    :href="href"
    class="font-medium flex h-full items-center border-b-2 border-transparent hover:border-white px-4"
  >
    {{ label }}
  </Link>
</template>
