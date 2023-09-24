<script lang="ts" setup>
import { ref } from 'vue';
import EaterySuggestEditsModal from '@/Components/PageSpecific/EatingOut/Details/Modals/EaterySuggestEditsModal.vue';

defineProps<{
  name: string;
  id: number;
}>();

const showModal = ref(false);

const emits = defineEmits(['openReport']);
</script>

<template>
  <div
    class="mx-3 cursor-pointer rounded border border-primary bg-primary-lightest p-2 transition hover:bg-primary-light lg:mx-0"
    @click="showModal = true"
  >
    Can you improve the information we hold for
    <span
      class="font-semibold"
      v-text="name"
    />?
  </div>

  <EaterySuggestEditsModal
    :eatery-name="name"
    :eatery-id="id"
    :show="showModal"
    @close="showModal = false"
    @open-report="emits('openReport')"
  />
</template>
