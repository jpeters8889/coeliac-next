<script lang="ts" setup>
import { HeadingBackLink } from '@/types/Types';
import { Link } from '@inertiajs/vue3';

withDefaults(
  defineProps<{
    as?: string;
    border?: boolean;
    backLink?: HeadingBackLink;
  }>(),
  {
    as: 'h1',
    border: true,
    backLink: undefined,
  },
);
</script>

<template>
  <div
    :class="{ 'border-gray-light border-b pb-2': border }"
    class="flex flex-col"
  >
    <component
      :is="as"
      class="text-center font-coeliac text-3xl font-semibold md:text-4xl lg:text-5xl mb-0!"
    >
      <slot />
    </component>

    <div
      v-if="backLink"
      class="mt-4 text-center text-sm font-semibold text-primary-dark transition hover:text-grey"
    >
      <Link :href="backLink.href">
        {{ backLink.label }}
      </Link>
    </div>
  </div>
</template>
