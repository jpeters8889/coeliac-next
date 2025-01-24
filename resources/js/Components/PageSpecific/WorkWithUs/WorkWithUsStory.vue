<script setup lang="ts">
import Card from '@/Components/Card.vue';

withDefaults(
  defineProps<{
    title: string;
    image: string;
    links: { href: string; label: string }[];
    noSmallImage?: boolean;
  }>(),
  {
    noSmallImage: false,
  },
);
</script>

<template>
  <div class="@container">
    <Card class="flex flex-col space-y-5 h-full @xl:p-8">
      <h2
        class="font-semibold text-primary-dark text-3xl text-center @sm:text-left @xl:text-4xl"
        v-text="title"
      />

      <div class="flex flex-col @sm:space-x-5 @sm:flex-row w-full h-full">
        <div class="flex flex-col space-y-5 flex-1 h-full">
          <p class="prose prose-lg @xl:prose-xl flex flex-1 max-w-none">
            <img
              v-if="!noSmallImage"
              :src="image"
              :alt="title"
              class="w-1/2 float-right ml-2 mb-2 @sm:hidden"
              loading="lazy"
            />
            <slot />
          </p>

          <ul
            v-if="links.length > 0"
            class="prose prose-lg @xl:prose-xl"
          >
            <li
              v-for="link in links"
              :key="link.href"
              class="pl-0 ps-0! my-0 font-semibold text-primary-dark hover:text-black"
            >
              <a
                :href="link.href"
                target="_blank"
                v-text="link.label"
              />
            </li>
          </ul>
        </div>

        <div class="hidden @sm:block @sm:w-1/4 @-sm:shrink-0 @sm:max-w-xs">
          <img
            :src="image"
            :alt="title"
            class="w-full float-right"
            loading="lazy"
          />
        </div>
      </div>
    </Card>
  </div>
</template>
