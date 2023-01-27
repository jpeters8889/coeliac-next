<script setup lang="ts">
import Bars3BottomLeftIcon from '@heroicons/vue/24/outline/Bars3BottomLeftIcon';
import MagnifyingGlassIcon from '@heroicons/vue/24/outline/MagnifyingGlassIcon';
import CoeliacMetas from '@/Layouts/Components/CoeliacMetas.vue';
import MobileNav from '@/Layouts/Components/MobileNav.vue';
import { ref } from 'vue';

const mobileNavOpen = ref(false);

</script>

<template>
  <CoeliacMetas />

  <header class="flex flex-col bg-primary">
    <div class="flex justify-between">
      <div class="w-12 h-12 p-2">
        <Bars3BottomLeftIcon @click.stop="mobileNavOpen = true" />
      </div>

      <MobileNav
        :open="mobileNavOpen"
        @close="mobileNavOpen = false"
      />

      <div>
        Logo
      </div>

      <div class="p-2 w-12 h-12">
        <div class="bg-secondary rounded-full w-8 h-8 flex justify-center items-center">
          <MagnifyingGlassIcon class="w-5 h-5" />
        </div>
      </div>
    </div>
  </header>
</template>
