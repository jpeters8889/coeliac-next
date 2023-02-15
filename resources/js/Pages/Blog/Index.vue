<script setup lang="ts">
import { PaginatedResponse } from '@/types/GenericTypes';
import { BlogDetailCard } from '@/types/BlogTypes';

defineProps({
  blogs: {
    required: true,
    type: Object as () => PaginatedResponse<BlogDetailCard>,
  },
});
</script>

<template>
  Hello World
</template>
