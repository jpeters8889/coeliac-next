<script setup lang="ts">
import {
  Bars3BottomLeftIcon,
  MagnifyingGlassIcon,
} from '@heroicons/vue/24/outline';
import { ref } from 'vue';
import MobileNav from '@/Layouts/Components/Nav/MobileNav.vue';
import CoeliacMetas from '@/Layouts/Components/CoeliacMetas.vue';
import MainNav from '@/Layouts/Components/Nav/MainNav.vue';
import Sealic from '@/Svg/Sealic.vue';
import { Link } from '@inertiajs/vue3';
import { MetaProps } from '@/types/DefaultProps';

defineProps<{ metas: MetaProps }>();
const mobileNavOpen = ref(false);
</script>

<template>
  <CoeliacMetas :metas="metas" />

  <div class="relative bg-primary shadow-lg">
    <div
      id="header"
      class="relative z-20"
    >
      <div class="mx-auto flex w-full items-start justify-between px-2">
        <div class="md:hidden">
          <a
            class="flex items-center justify-center rounded-md text-white/80 hover:text-white"
          >
            <Bars3BottomLeftIcon
              class="h-10 w-10"
              @click="mobileNavOpen = true"
            />
          </a>
        </div>

        <Link
          class="my-2 flex flex-1"
          href="/"
        >
          <Sealic class="h-10" />
        </Link>

        <MainNav />

        <div class="h-14 w-14 p-2">
          <div
            class="flex h-10 w-10 items-center justify-center rounded-full bg-secondary"
          >
            <MagnifyingGlassIcon class="h-6 w-6" />
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
