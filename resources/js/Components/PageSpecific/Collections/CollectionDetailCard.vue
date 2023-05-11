<script setup lang="ts">
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import { CollectionDetailCard } from '@/types/CollectionTypes';

defineProps({
  collection: {
    required: true,
    type: Object as () => CollectionDetailCard,
  },
});
</script>

<template>
  <Card>
    <div class="group flex-1">
      <Link
        :href="collection.link"
        class="-m-4 flex flex-col mb-0"
      >
        <img
          :src="collection.image"
          :alt="collection.title"
          loading="lazy"
        >
      </Link>

      <div class="flex flex-col space-y-3 mt-4 flex-1">
        <Link :href="collection.link">
          <h2
            class="text-xl font-semibold transition hover:text-primary-dark group-hover:text-primary-dark"
            v-text="collection.title"
          />
        </Link>

        <div class="flex flex-1">
          <p
            v-text="collection.description"
          />
        </div>
      </div>
    </div>

    <div class="bg-grey-light -m-4 mt-4 p-4 shadow-inner flex flex-col text-sm">
      <p>Last updated on {{ collection.date }}</p>
      <p>{{ collection.number_of_items }} items in this collection.</p>
    </div>
  </Card>
</template>
