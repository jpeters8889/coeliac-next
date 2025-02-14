<script lang="ts" setup>
import { InformationCircleIcon } from '@heroicons/vue/20/solid';

withDefaults(defineProps<{ noIcon?: boolean; faded?: boolean }>(), {
  noIcon: false,
});
</script>

<template>
  <div class="rounded-sm border-2 p-2 shadow-sm border-primary bg-primary/20">
    <div
      v-if="!noIcon"
      class="float-left pr-2 text-primary"
    >
      <InformationCircleIcon class="h-10 w-10" />
    </div>

    <slot />
  </div>
</template>
