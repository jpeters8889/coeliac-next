<script lang="ts" setup>
import { DetailedEatery } from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';
import Icon from '@/Components/Icon.vue';

defineProps<{
  name: string;
  features: DetailedEatery['features'];
}>();
</script>

<template>
  <Card class="space-y-2">
    <p class="prose mb-2 max-w-none sm:prose-lg">
      Here are some highlights you can get at <strong>{{ name }}</strong>
    </p>

    <ul
      class="grid grid-cols-1 gap-2 xxs:grid-cols-2 sm:grid-cols-3 xmd:grid-cols-4 xmd:gap-3 xl:grid-cols-6"
    >
      <li
        v-for="feature in features"
        :key="feature.slug"
        class="flex items-center space-x-2 leading-none"
      >
        <div class="h-8 w-8 flex-shrink-0 text-primary">
          <Icon
            :name="feature.slug"
            class="h-8 w-8"
          />
        </div>

        <span class="block font-semibold leading-none">
          {{ feature.name }}
        </span>
      </li>
    </ul>
  </Card>
</template>
