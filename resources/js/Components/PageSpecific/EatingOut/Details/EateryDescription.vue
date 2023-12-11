<script lang="ts" setup>
import { DetailedEatery } from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';

defineProps<{
  eatery: DetailedEatery;
}>();
</script>

<template>
  <Card class="space-y-2">
    <template v-if="eatery.restaurants.length">
      <div
        v-for="restaurant in eatery.restaurants"
        :key="restaurant.name"
      >
        <h4
          v-if="restaurant.name"
          class="text-lg font-semibold md:text-xl"
        >
          {{ restaurant.name }}
        </h4>

        <p class="prose max-w-none md:prose-lg">
          {{ restaurant.info }}
        </p>
      </div>
    </template>

    <template v-else>
      <p
        class="prose max-w-none sm:prose-lg"
        v-html="eatery.info"
      />
    </template>

    <p class="text-sm italic">Last Updated: {{ eatery.last_updated_human }}</p>
  </Card>
</template>
