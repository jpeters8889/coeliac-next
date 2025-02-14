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
  <Card class="space-y-2 lg:rounded-lg lg:p-8 lg:space-y-4">
    <p class="prose mb-2 max-w-none sm:prose-lg lg:prose-xl">
      Here are some highlights you can get at <strong>{{ name }}</strong>
    </p>

    <ul
      class="grid grid-cols-1 gap-2 xxs:max-sm:grid-cols-2 sm:max-xmd:grid-cols-3 xmd:max-xl:grid-cols-4 xmd:gap-3 lg:gap-3 xl:grid-cols-6"
    >
      <li
        v-for="feature in features"
        :key="feature.slug"
        class="flex items-center space-x-2 leading-none lg:space-x-4"
      >
        <div class="h-8 w-8 lg:h-12 lg:w-12 shrink-0 text-primary">
          <Icon
            :name="feature.slug"
            class="h-8 w-8 lg:h-12 lg:w-12"
          />
        </div>

        <span class="block font-semibold leading-none lg:text-xl">
          {{ feature.name }}
        </span>
      </li>
    </ul>
  </Card>
</template>
