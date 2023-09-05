<script lang="ts" setup>
import { DetailedEatery } from '@/types/EateryTypes';
import { ref } from 'vue';

defineProps<{
  eatery: DetailedEatery;
}>();

const showModal = ref(false);
</script>

<template>
  <div
    class="mx-3 cursor-pointer rounded border border-primary bg-primary-lightest p-2 transition hover:bg-primary-light lg:mx-0"
    @click="showModal = true"
  >
    Can you improve the information we hold for
    <span class="font-semibold">{{ eatery.name }}</span
    >?
  </div>
</template>
