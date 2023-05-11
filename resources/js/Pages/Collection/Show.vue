<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import Heading from '@/Components/Heading.vue';
import { CollectionPage } from '@/types/CollectionTypes';
import CollectionItemCard from "@/Components/PageSpecific/Collections/CollectionItemCard.vue";

defineProps({
  collection: {
    required: true,
    type: Object as () => CollectionPage,
  },
});
</script>

<template>
  <Card class="mt-3 flex flex-col space-y-4">
    <Heading>
      {{ collection.title }}
    </Heading>

    <div
      class="prose prose-lg font-semibold max-w-none"
      v-text="collection.description"
    />

    <div class="bg-grey-light -m-4 !-mb-4 p-4 shadow-inner">
      <p v-if="collection.updated">
        <span class="font-semibold">Last updated</span> {{ collection.updated }}
      </p>
      <p><span class="font-semibold">Added</span> {{ collection.published }}</p>
    </div>
  </Card>

  <Card no-padding>
    <img
      :src="collection.image"
      :alt="collection.title"
      loading="lazy"
    >
  </Card>

  <Card
    v-if="collection.body"
    class="space-y-3"
  >
    <article
      class="prose prose-lg max-w-none"
      v-html="collection.body"
    />
  </Card>

  <CollectionItemCard
    v-for="item in collection.items"
    :key="item.title"
    :item="item"
  />
</template>
