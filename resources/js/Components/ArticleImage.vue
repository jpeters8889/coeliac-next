<script lang="ts" setup>
import { ref } from 'vue';
import Modal from '@/Components/Overlays/Modal.vue';

const props = defineProps({
  src: {
    required: true,
    type: String,
  },
  title: {
    type: String,
    default: null,
  },
  position: {
    type: String,
    default: 'left',
  },
});

const zoomed = ref(false);

const classes = (): string[] => {
  const classList = [
    'w-auto',
    'p-2',
    'mx-0',
    'my-2',
    'sm:m-2',
    'bg-primary',
    'bg-opacity-20',
    'w-full',
  ];

  if (props.position !== 'fullwidth') {
    classList.push('max-w-half', 'sm:max-w-1/2', 'lg:max-w-1/3');
  }

  if (props.position === 'left') {
    classList.push('sm:ml-0', 'float-left');
  }

  if (props.position === 'right') {
    classList.push('sm:mr-0', 'float-right');
  }

  return classList;
};
</script>

<template>
  <div :class="classes()">
    <img
      :src="src"
      :alt="title"
      loading="lazy"
      class="w-full h-auto m-0"
      style="cursor: zoom-in"
      @click="zoomed = true"
    >
    <div
      v-if="title"
      class="text-center text-sm mt-2 leading-none md:text-base"
    >
      {{ title }}
    </div>
  </div>

  <Modal
    :open="zoomed"
    size="full"
    closeable
    no-padding
    @close="zoomed = false"
  >
    <img
      :src="src"
      :alt="title"
      class="w-full"
    >

    <template #footer>
      <p
        class="text-sm md:text-base"
        v-html="title"
      />
    </template>
  </Modal>
</template>
