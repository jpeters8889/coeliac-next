<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import HomeHoverItem from '@/Components/PageSpecific/Home/HomeHoverItem.vue';
import { HomeHoverItem as HomeHoverItemType } from '@/types/Types';

defineProps({
  title: {
    required: true,
    type: String,
  },
  items: {
    required: true,
    type: Array as () => HomeHoverItemType[],
  },
  perRow: {
    required: false,
    type: Number,
    default: 3,
  },
});
</script>

<template>
  <Card>
    <h2 class="text-3xl font-semibold font-coeliac">
      {{ title }}
    </h2>

    <div
      class="my-2 w-4/5 mx-auto h-px bg-gradient-to-r from-secondary/40 via-secondary/60 to-secondary/40"
    />

    <section
      class="group grid grid-cols-1"
      :class="{'sm:grid-cols-3': perRow === 3,'sm:grid-cols-4': perRow === 4}"
    >
      <HomeHoverItem
        v-for="item in items"
        :key="item.link"
        :item="item"
      />
    </section>
  </Card>
</template>
