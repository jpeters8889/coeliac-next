<script lang="ts" setup>
import { ref } from 'vue';
import Modal from '@/Components/Overlays/Modal.vue';

const props = withDefaults(
  defineProps<{
    src: string;
    title?: string;
    position: string;
  }>(),
  { title: undefined, position: 'left' },
);

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
      :alt="title"
      :src="src"
      class="m-0 h-auto w-full"
      loading="lazy"
      style="cursor: zoom-in"
      @click="zoomed = true"
    />
    <div
      v-if="title"
      class="mt-2 text-center text-sm leading-none md:text-base"
    >
      {{ title }}
    </div>
  </div>

  <Modal
    :open="zoomed"
    closeable
    no-padding
    size="full"
    @close="zoomed = false"
  >
    <img
      :alt="title"
      :src="src"
      class="w-full"
    />

    <template #footer>
      <p
        class="text-sm md:text-base"
        v-html="title"
      />
    </template>
  </Modal>
</template>
