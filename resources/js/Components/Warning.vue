<script lang="ts" setup>
import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid';
</script>

<template>
  <div
    class="rounded border-2 border-red-dark bg-red-dark bg-opacity-20 p-2 shadow"
  >
    <div class="float-left pr-2 text-red-dark">
      <ExclamationTriangleIcon class="h-10 w-10" />
    </div>

    <slot />
  </div>
</template>
