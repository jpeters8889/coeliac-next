<script setup lang="ts">
import { DocumentArrowUpIcon, EnvelopeOpenIcon, MapIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
  county: {
    type: String,
    required: true,
  },
});

const linkCards = [
  {
    title: 'Recommend a place',
    description: `Do you know somewhere in <span class="font-semibold">${props.county}</span> that offers gluten free that we don't have listed? Let us know!`,
    icon: DocumentArrowUpIcon,
  },
  {
    title: 'Map',
    description: `Browse an interactive map of <span class="font-semibold">${props.county}</span> with all of the places we know about marked that offer gluten free!`,
    icon: MapIcon,
  },
  {
    title: 'Subscribe',
    description: `Subscribe to <span class="font-semibold">${props.county}</span> and get notified straight into your inbox whenever we add a new location!`,
    icon: EnvelopeOpenIcon,
  },
];
</script>

<template>
  <div class="grid gap-2 grid-cols-3 px-2">
    <div
      v-for="(item) in linkCards"
      :key="item.title"
      class="flex-shrink-0"
    >
      <div
        class="bg-gradient-to-br from-primary/70 to-primary-light/70 rounded p-2 shadow flex flex-col items-center justify-center space-y-2 w-full h-full md:p-4 md:justify-between"
      >
        <div class="flex flex-col items-center justify-center flex-1 md:flex-row-reverse md:w-full md:items-start md:flex-none">
          <div class="flex-1 mb-2 xs:mb-4 md:flex-none md:mb-0">
            <component
              :is="item.icon"
              class="w-12 h-12 sm:w-14 sm:h-14 md:w-8 md:h-8"
            />
          </div>

          <div class="text-sm font-semibold text-center xs:text-base sm:text-lg md:text-left md:flex-1 md:text-xl">
            {{ item.title }}
          </div>
        </div>
        <p
          class="hidden text-sm md:inline"
          v-html="item.description"
        />
      </div>
    </div>
  </div>
</template>
