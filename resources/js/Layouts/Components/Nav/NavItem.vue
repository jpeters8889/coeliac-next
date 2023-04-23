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
  active: {
    type: Boolean,
    required: false,
    default: false,
  },
});
</script>

<template>
  <Link
    :href="href"
    class="font-medium flex h-full items-center border-transparent px-4"
    :class="{'border-b-4 border-secondary': active, 'border-b-2 hover:border-white': !active}"
  >
    {{ label }}
  </Link>
</template>
