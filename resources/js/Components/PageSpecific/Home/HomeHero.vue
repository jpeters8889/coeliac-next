<script setup lang="ts">
import { Ref, ref } from 'vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';

type HeroItem = { title: string; image: string };

const items: HeroItem[] = [
  {
    title: 'Have you got your travel cards?',
    image: '/images/travel-cards.png',
  },
  {
    title: 'Have you got your gluten free stickers?',
    image: '/images/stickers.jpg',
  },
];

let activeIndex: number = 0;
const activeItem: Ref<HeroItem> = ref(items[0]);

setInterval(() => {
  if (activeIndex === items.length - 1) {
    activeItem.value = items[0];
    activeIndex = 0;

    return;
  }

  activeIndex += 1;
  activeItem.value = items[activeIndex];
}, 5000);
</script>
<template>
  <div class="relative bg-primary-light/50">
    <div class="mx-auto w-full max-w-8xl">
      <div class="relative z-10">
        <div
          class="relative px-6 py-10 sm:py-12 md:py-14 xmd:py-16 lg:py-20 xl:py-24"
        >
          <div class="mx-auto max-w-5xl">
            <h1
              class="mx-auto bg-secondary/60 p-2 text-center text-2xl font-semibold tracking-tight text-gray-900 sm:w-4/5 sm:leading-8"
              v-text="activeItem.title"
            />
            <p
              class="mx-auto mt-6 bg-white/70 p-2 text-center text-lg leading-6 text-gray-600 sm:w-4/5 sm:leading-8"
            >
              Check out our online shop for some great coeliac related goodies,
              including our fantastic travel cards for when you go abroad, our
              'Gluten Free' stickers, our wristbands, and much more too!
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
              <CoeliacButton
                label="View all Products"
                href="/shop"
                size="xl"
                theme="secondary"
                bold
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="absolute bottom-0 h-full w-full bg-gray-50">
      <div
        class="absolute h-full w-full bg-gradient-to-b from-primary-light/70 to-primary-light/60"
      />
      <img
        class="h-full w-full object-cover"
        :src="activeItem.image"
        :alt="activeItem.title"
      />
    </div>
  </div>
</template>
