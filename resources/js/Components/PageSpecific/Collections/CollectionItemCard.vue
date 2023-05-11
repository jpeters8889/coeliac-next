<script setup lang="ts">
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import { CollectionItem } from '@/types/CollectionTypes';
import RecipeSquareImage from '@/Components/PageSpecific/Recipes/RecipeSquareImage.vue';

defineProps({
  item: {
    required: true,
    type: Object as () => CollectionItem,
  },
});
</script>

<template>
  <Card class="flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-4">
    <div class="md:min-w-1/4 md:max-w-16">
      <Link
        :href="item.link"
        class="flex flex-col mb-0"
      >
        <img
          v-if="item.type !== 'Recipe' || (item.type === 'Recipe' && item.square_image)"
          :src="item.image"
          :alt="item.title"
          loading="lazy"
        >
        <RecipeSquareImage
          v-else
          :src="item.image"
          :alt="item.title"
        />
      </Link>
    </div>

    <div class="flex flex-col space-y-3 mt-4 flex-1">
      <Link :href="item.link">
        <h2
          class="text-xl font-semibold transition text-primary-dark hover:text-grey-dark md:text-2xl"
          v-text="item.title"
        />
      </Link>

      <div class="flex flex-1">
        <p
          class="prose prose-md max-w-none"
          v-text="item.description"
        />
      </div>

      <div class="flex-1 flex justify-between items-end">
        <p class="text-xs">
          Added on {{ item.date }}
        </p>
        <div class="bg-primary-light bg-opacity-50 rounded-lg py-2 px-4 leading-none text-sm font-semibold">
          <span v-text="item.type" />
        </div>
      </div>
    </div>
  </Card>
</template>
