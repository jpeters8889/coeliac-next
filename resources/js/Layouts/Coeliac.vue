<script lang="ts" setup>
import CoeliacHeader from '@/Layouts/Components/CoeliacHeader.vue';
import CoeliacFooter from '@/Layouts/Components/CoeliacFooter.vue';
import { MetaProps } from '@/types/DefaultProps';
import { ShoppingBagIcon } from '@heroicons/vue/24/solid';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ShopBasketHeader from '@/Layouts/Components/ShopBasketHeader.vue';
import ShopFooterCta from '@/Layouts/Components/ShopFooterCta.vue';

defineProps<{ meta: MetaProps }>();

const isShop = computed((): boolean => usePage().component.includes('Shop'));
</script>

<template>
  <body class="relative flex min-h-screen flex-col bg-gray-100">
    <CoeliacHeader :metas="meta" />

    <ShopBasketHeader v-if="isShop" />

    <section
      class="mx-auto mb-3 flex w-full max-w-8xl flex-1 flex-col space-y-3"
    >
      <slot />
    </section>

    <CoeliacFooter />

    <ShopFooterCta v-if="isShop" />
  </body>
</template>
