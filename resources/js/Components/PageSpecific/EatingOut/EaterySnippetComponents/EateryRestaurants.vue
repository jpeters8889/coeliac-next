<script lang="ts" setup>
import { TownEatery } from '@/types/EateryTypes';

defineProps<{ restaurants: TownEatery['restaurants'] }>();
</script>

<template>
  <div
    v-for="(restaurant, index) in restaurants"
    :key="index"
  >
    <h4
      v-if="restaurant.name"
      class="font-semibold md:text-lg"
    >
      {{ restaurant.name }}
    </h4>

    <p class="prose max-w-none md:prose-lg">
      {{ restaurant.info }}
    </p>
  </div>
</template>
