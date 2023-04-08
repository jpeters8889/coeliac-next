<script setup lang="ts">
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import { RecipeSimpleCard } from '@/types/RecipeTypes';

defineProps({
  recipe: {
    required: true,
    type: Object as () => RecipeSimpleCard,
  },
});
</script>

<template>
  <Card
    :shadow="false"
    class="transform scale-95 hover:scale-105 transition duration-500 hover:!opacity-100"
  >
    <Link
      :href="recipe.link"
      class="group -m-4"
    >
      <img
        :src="recipe.image"
        :alt="recipe.title"
        loading="lazy"
      >

      <h2
        class="text-base group-hover:text-primary-dark transition p-2 font-semibold text-center"
        v-text="recipe.title"
      />
    </Link>
  </Card>
</template>
