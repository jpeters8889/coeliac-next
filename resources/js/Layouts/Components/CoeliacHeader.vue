<script setup lang="ts">
import { Bars3BottomLeftIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';
import MobileNav from '@/Layouts/Components/Nav/MobileNav.vue';
import CoeliacMetas from '@/Layouts/Components/CoeliacMetas.vue';
import MainNav from '@/Layouts/Components/Nav/MainNav.vue';

const mobileNavOpen = ref(false);

</script>

<template>
  <CoeliacMetas />

  <div class="relative bg-primary h-14">
    <div
      class="pointer-events-none absolute inset-0 z-30 shadow"
      aria-hidden="true"
    />
    <div class="relative z-20">
      <div class="mx-auto flex max-w-8xl items-center justify-between p-2 h-14 xmd:justify-start xmd:space-x-10 xmd:p-0">
        <div class="xmd:hidden">
          <a class="flex items-center justify-center rounded-md text-white/80 hover:text-white">
            <Bars3BottomLeftIcon
              class="h-10 w-10"
              @click="mobileNavOpen = true"
            />
          </a>
        </div>

        <div>Logo</div>

        <MainNav />

        <div class="p-2 w-14 h-14">
          <div class="bg-secondary rounded-full w-10 h-10 flex justify-center items-center">
            <MagnifyingGlassIcon class="w-6 h-6" />
          </div>
        </div>
      </div>
    </div>

    <MobileNav
      :open="mobileNavOpen"
      @close="mobileNavOpen = false"
    />
  </div>
</template>
