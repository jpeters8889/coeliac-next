<script setup lang="ts">
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import { HomeHoverItem as HomeHoverItemType } from '@/types/Types';

defineProps({
  item: {
    required: true,
    type: Object as () => HomeHoverItemType,
  },
});
</script>

<template>
  <Card
    :shadow="false"
    class="group-hover:opacity-50 transform scale-95 hover:scale-105 transition duration-500 hover:!opacity-100"
  >
    <Link
      :href="item.link"
      class="group -m-4"
    >
      <img
        :src="item.image"
        :alt="item.title"
      >

      <h2
        class="text-base group-hover:text-primary-dark transition p-2 font-semibold text-center"
        v-text="item.title"
      />
    </Link>
  </Card>
</template>
