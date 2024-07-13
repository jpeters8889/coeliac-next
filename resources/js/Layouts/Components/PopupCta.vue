<script setup lang="ts">
import { PopupProps } from '@/types/DefaultProps';
import Modal from '@/Components/Overlays/Modal.vue';
import { onMounted, ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps<{ popup: PopupProps }>();

const displayModal = ref(false);

const handlePopupClick = () => {
  // google track

  router.get(props.popup.link);
};

onMounted(() => {
  if (window.innerWidth <= 360) {
    return;
  }

  setTimeout(() => {
    displayModal.value = true;

    axios.post(`/popup/${props.popup.id}`).then(() => {
      //
    });
  }, 6000);
});
</script>

<template>
  <Modal
    :open="displayModal"
    no-padding
    size="large"
    @close="displayModal = false"
  >
    <Link
      class="block"
      :href="popup.link"
      @click.prevent="handlePopupClick()"
    >
      <img
        :src="popup.image"
        :alt="popup.text"
      />
    </Link>

    <template #footer>
      <div
        class="prose prose-xl lg:prose-2xl text-center w-full max-w-none"
        v-text="popup.text"
      />
    </template>
  </Modal>
</template>
