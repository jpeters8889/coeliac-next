<script setup lang="ts">
import {
  Bars3BottomLeftIcon,
  MagnifyingGlassIcon,
} from '@heroicons/vue/24/outline';
import { ref } from 'vue';
import MobileNav from '@/Layouts/Components/Nav/MobileNav.vue';
import CoeliacMetas from '@/Layouts/Components/CoeliacMetas.vue';
import MainNav from '@/Layouts/Components/Nav/MainNav.vue';
import Sealiac from '@/Svg/Sealiac.vue';
import { Link } from '@inertiajs/vue3';
import { MetaProps } from '@/types/DefaultProps';
import MobileSearch from '@/Layouts/Components/MobileSearch.vue';
import DesktopSearch from '@/Layouts/Components/DesktopSearch.vue';

defineProps<{ metas: MetaProps }>();

const mobileNavOpen = ref(false);
const mobileSearchOpen = ref(false);
</script>

<template>
  <CoeliacMetas :metas="metas" />

  <div class="relative bg-primary shadow-lg">
    <div
      id="header"
      class="relative z-20"
    >
      <div
        class="mx-auto flex w-full max-w-8xl items-start justify-between px-2 gap-2"
      >
        <div
          class="md:hidden flex items-center justify-center rounded-md text-white/80 hover:text-white py-2"
        >
          <Bars3BottomLeftIcon
            class="h-10 w-10"
            @click="mobileNavOpen = true"
          />
        </div>

        <Link href="/">
          <Sealiac class="py-2 w-full" />
        </Link>

        <div class="md:w-full md:max-w-xs">
          <div class="h-10 w-10 py-2 md:hidden">
            <div
              class="flex h-10 w-10 items-center justify-center rounded-full bg-secondary"
              @click="mobileSearchOpen = true"
            >
              <MagnifyingGlassIcon class="h-6 w-6" />
            </div>
          </div>

          <DesktopSearch />
        </div>
      </div>

      <div
        class="mx-auto hidden h-px w-4/5 bg-linear-to-r from-white/20 via-white/40 to-white/20 md:block"
      />

      <MainNav />
    </div>
  </div>

  <MobileNav
    :open="mobileNavOpen"
    @close="mobileNavOpen = false"
  />

  <MobileSearch
    :open="mobileSearchOpen"
    @close="mobileSearchOpen = false"
  />
</template>
