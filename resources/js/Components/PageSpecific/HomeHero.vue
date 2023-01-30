<script setup lang="ts">
import { Ref, ref } from 'vue';

type HeroItem = { title: string, image: string };

const items: HeroItem[] = [
  { title: 'Have you got your travel cards?', image: '/images/travel-cards.png' },
  { title: 'Have you got your stickers?', image: '/images/stickers.jpg' },
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
}, 3000);

</script>
<template>
  <section class="w-full bg-primary-lightest flex flex-col sm:flex-row">
    <div class="px-2 py-6 sm:w-2/3 sm:p-6 sm:pt-8 sm:flex-grow-0">
      <h2
        class="text-center font-semibold text-xl mb-6 bg-secondary/50 p-2 rotate-1 sm:-rotate-2 sm:mb-8"
        v-text="activeItem.title"
      />

      <p class="bg-white/90 text-center p-2 text-lg">
        Check out our online shop for some great coeliac related goodies, including our fantastic travel cards
        for when you go abroad, our 'Gluten Free' stickers, our wristbands, and much more too!
      </p>
    </div>

    <div class="p-2 w-4/5 mx-auto pb-6 sm:w-1/3 sm:p-6 sm:pl-0 sm:pt-8 sm:flex-grow-0">
      <div class="border-secondary border-4 rounded-lg mx-auto overflow-hidden shadow -rotate-1 max-w-xs sm:rotate-2">
        <img
          :src="activeItem.image"
          :alt="activeItem.title"
        >
      </div>
    </div>
  </section>
</template>
