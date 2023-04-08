<script setup lang="ts">
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import { BlogSimpleCard } from '@/types/BlogTypes';

defineProps({
  blog: {
    required: true,
    type: Object as () => BlogSimpleCard,
  },
});
</script>

<template>
  <Card
    :shadow="false"
    class="transform scale-95 hover:scale-105 transition duration-500 hover:!opacity-100"
  >
    <Link
      :href="blog.link"
      class="group -m-4"
    >
      <img
        :src="blog.image"
        :alt="blog.title"
        loading="lazy"
      >

      <h2
        class="text-base group-hover:text-primary-dark transition p-2 font-semibold text-center"
        v-text="blog.title"
      />
    </Link>
  </Card>
</template>
