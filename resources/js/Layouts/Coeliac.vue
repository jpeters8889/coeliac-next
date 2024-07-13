<script lang="ts" setup>
import CoeliacHeader from '@/Layouts/Components/CoeliacHeader.vue';
import CoeliacFooter from '@/Layouts/Components/CoeliacFooter.vue';
import { MetaProps, PopupProps } from '@/types/DefaultProps';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ShopBasketHeader from '@/Layouts/Components/ShopBasketHeader.vue';
import ShopFooterCta from '@/Layouts/Components/ShopFooterCta.vue';
import PopupCta from '@/Layouts/Components/PopupCta.vue';

defineProps<{ meta: MetaProps; popup?: PopupProps }>();

const isShop = computed(
  (): boolean =>
    usePage().component.includes('Shop') &&
    usePage().component !== 'Shop/Checkout' &&
    usePage().component !== 'Shop/OrderComplete' &&
    usePage().component !== 'Shop/ReviewMyOrder',
);
</script>

<template>
  <div class="relative flex min-h-screen flex-col bg-gray-100">
    <CoeliacHeader :metas="meta" />

    <ShopBasketHeader v-if="isShop" />

    <section
      class="mx-auto mb-3 flex w-full max-w-8xl flex-1 flex-col space-y-3"
    >
      <slot />
    </section>

    <CoeliacFooter />

    <ShopFooterCta v-if="isShop" />

    <PopupCta
      v-if="popup"
      :popup="popup"
    />
  </div>
</template>
