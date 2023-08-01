<script lang="ts" setup>
import { HomepageCollection } from '@/types/CollectionTypes';
import Card from '@/Components/Card.vue';
import HomeHoverItem from '@/Components/PageSpecific/Home/HomeHoverItem.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{ collection: HomepageCollection }>();
</script>

<template>
  <Card>
    <h2 class="font-coeliac text-3xl font-semibold">
      {{ collection.title }}
    </h2>

    <p
      class="prose-md prose max-w-none"
      v-html="collection.description"
    />

    <div
      class="my-2 mx-auto h-px w-4/5 bg-gradient-to-r from-secondary/40 via-secondary/60 to-secondary/40"
    />

    <section class="group grid grid-cols-1 sm:grid-cols-3">
      <HomeHoverItem
        v-for="item in collection.items"
        :key="item.link"
        :item="item"
      />
    </section>

    <Link
      :href="collection.link"
      class="text-lg font-semibold text-primary-dark transition hover:text-grey-dark"
    >
      View more {{ collection.title }} items
    </Link>
  </Card>
</template>
