<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import { HomeHoverItem as HomeHoverItemType } from '@/types/Types';
import RecipeSquareImage from '@/Components/PageSpecific/Recipes/RecipeSquareImage.vue';

defineProps<{ item: HomeHoverItemType }>();
</script>

<template>
  <Card
    :shadow="false"
    class="scale-95 transform transition duration-500 hover:scale-105 hover:!opacity-100 group-hover:opacity-50"
  >
    <Link
      :href="item.link"
      class="group -m-4"
    >
      <img
        v-if="
          item.type !== 'Recipe' ||
          (item.type === 'Recipe' && item.square_image)
        "
        :alt="item.title"
        :src="item.image"
      />
      <RecipeSquareImage
        v-else
        :alt="item.title"
        :src="item.image"
      />

      <h2
        class="p-2 text-center text-base font-semibold transition group-hover:text-primary-dark md:text-lg"
        v-text="item.title"
      />
    </Link>
  </Card>
</template>
