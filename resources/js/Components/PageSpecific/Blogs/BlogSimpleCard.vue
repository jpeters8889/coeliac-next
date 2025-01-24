<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import { BlogDetailCard } from '@/types/BlogTypes';

defineProps<{ blog: BlogDetailCard }>();
</script>

<template>
  <Card
    :shadow="false"
    class="scale-95 transform transition duration-500 hover:scale-105 hover:opacity-100!"
  >
    <Link
      :href="blog.link"
      class="group -m-4"
    >
      <img
        :alt="blog.title"
        :src="blog.image"
        loading="lazy"
      />

      <h2
        class="p-2 text-center text-base font-semibold transition group-hover:text-primary-dark"
        v-text="blog.title"
      />
    </Link>
  </Card>
</template>
