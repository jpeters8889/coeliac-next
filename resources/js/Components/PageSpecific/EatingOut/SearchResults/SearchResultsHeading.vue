<script lang="ts" setup>
import { DocumentArrowUpIcon, MapIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/vue3';

defineProps<{
  term: string;
  image: string;
}>();

const linkCards = [
  {
    title: 'Recommend a place',
    description:
      "Do you know somewhere that offers gluten free that we don't have listed? Let us know!",
    icon: DocumentArrowUpIcon,
  },
  {
    title: 'Map',
    description:
      'Browse an interactive map with all of the places we know about marked that offer gluten free!',
    icon: MapIcon,
  },
];
</script>

<template>
  <div class="relative">
    <div
      class="my-3 xxs:absolute xxs:top-4 xxs:m-0 xxs:flex xxs:w-full xxs:justify-between xxs:p-3"
    >
      <div
        class="w-full bg-white p-2 text-center shadow xxs:w-auto xxs:rounded xxs:bg-primary-light/90 xxs:text-left xxs:shadow-lg xs:p-4"
      >
        <h1
          class="text-xl font-semibold xxs:text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl"
        >
          Gluten Free search results for {{ term }}
        </h1>

        <span
          class="mt-2 block text-sm font-semibold text-primary-dark hover:text-black md:text-base"
        >
          <Link href="/wheretoeat">Back to the eating out guide</Link>
        </span>
      </div>
    </div>

    <div class="absolute bottom-0 mb-2 grid w-full grid-cols-3 gap-2 px-2">
      <div
        v-for="item in linkCards"
        :key="item.title"
        class="flex-shrink-0"
      >
        <div
          class="flex h-full w-full cursor-pointer flex-col items-center justify-center space-y-2 rounded bg-gradient-to-br from-primary/90 to-primary-light/90 p-2 shadow shadow-lg transition duration-500 hover:sm:from-primary/95 hover:sm:to-primary-light/95 md:justify-between md:p-4"
        >
          <div
            class="flex flex-1 flex-col items-center justify-center xs:w-full xs:flex-row md:flex-none md:items-start"
          >
            <div
              class="mb-2 hidden flex-1 xs:mb-0 xs:mb-4 xs:mr-4 xs:block xs:flex-none"
            >
              <component
                :is="item.icon"
                class="h-12 w-12 xs:h-10 xs:w-10 md:h-8 md:w-8"
              />
            </div>

            <div
              class="text-center text-sm font-semibold xs:flex-1 xs:text-left xs:text-base md:text-xl lg:text-2xl"
            >
              {{ item.title }}
            </div>
          </div>
          <p
            class="hidden text-sm md:inline lg:text-base"
            v-html="item.description"
          />
        </div>
      </div>
    </div>

    <img
      v-if="image"
      :alt="`Gluten Free search results for ${term}`"
      :src="image"
      class="mt-4 w-full shadow"
      loading="lazy"
    />
  </div>
</template>
