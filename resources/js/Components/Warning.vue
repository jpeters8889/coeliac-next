<script lang="ts" setup>
import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid';

withDefaults(defineProps<{ noIcon?: boolean; faded?: boolean }>(), {
  noIcon: false,
  faded: false,
});
</script>

<template>
  <div
    class="rounded-sm border-2 bg-red-dark p-2 shadow-sm"
    :class="
      faded ? 'border-red/20 bg-red-dark/5' : 'border-red-dark bg-red-dark/20'
    "
  >
    <div
      v-if="!noIcon"
      class="float-left pr-2 text-red-dark"
    >
      <ExclamationTriangleIcon class="h-10 w-10" />
    </div>

    <slot />
  </div>
</template>
