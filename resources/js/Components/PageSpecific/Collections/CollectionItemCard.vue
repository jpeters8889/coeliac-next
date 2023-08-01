<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import { CollectionItem } from '@/types/CollectionTypes';
import RecipeSquareImage from '@/Components/PageSpecific/Recipes/RecipeSquareImage.vue';

defineProps<{ item: CollectionItem }>();
</script>

<template>
  <Card class="flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-4">
    <div class="md:min-w-1/4 md:max-w-16">
      <Link
        :href="item.link"
        class="mb-0 flex flex-col"
      >
        <img
          v-if="
            item.type !== 'Recipe' ||
            (item.type === 'Recipe' && item.square_image)
          "
          :alt="item.title"
          :src="item.image"
          loading="lazy"
        />
        <RecipeSquareImage
          v-else
          :alt="item.title"
          :src="item.image"
        />
      </Link>
    </div>

    <div class="mt-4 flex flex-1 flex-col space-y-3">
      <Link :href="item.link">
        <h2
          class="text-xl font-semibold text-primary-dark transition hover:text-grey-dark md:text-2xl"
          v-text="item.title"
        />
      </Link>

      <div class="flex flex-1">
        <p
          class="prose-md prose max-w-none"
          v-text="item.description"
        />
      </div>

      <div class="flex flex-1 items-end justify-between">
        <p class="text-xs">Added on {{ item.date }}</p>
        <div
          class="rounded-lg bg-primary-light bg-opacity-50 py-2 px-4 text-sm font-semibold leading-none"
        >
          <span v-text="item.type" />
        </div>
      </div>
    </div>
  </Card>
</template>
