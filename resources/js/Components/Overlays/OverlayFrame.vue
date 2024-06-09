<script setup lang="ts">
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue';

defineOptions({
  inheritAttrs: false,
});

withDefaults(
  defineProps<{
    open: boolean;
    width?: 'w-full' | 'w-auto';
  }>(),
  {
    width: 'w-auto',
  },
);

const emit = defineEmits(['close']);
</script>

<template>
  <Teleport to="body">
    <TransitionRoot
      :show="open"
      as="template"
    >
      <Dialog
        as="div"
        class="relative z-40"
        @close="emit('close')"
      >
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="ease-in duration-200"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div
            class="fixed inset-0 bg-black bg-opacity-75 transition-opacity"
          />
        </TransitionChild>

        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div
            class="flex min-h-full items-center justify-center p-4 text-center sm:p-0"
          >
            <TransitionChild
              as="template"
              enter="ease-out duration-300"
              enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              enter-to="opacity-100 translate-y-0 sm:scale-100"
              leave="ease-in duration-200"
              leave-from="opacity-100 translate-y-0 sm:scale-100"
              leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
              <DialogPanel
                :class="[width, $attrs['class']]"
                class="relative w-auto max-w-[95%] transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8"
              >
                <slot />
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </Teleport>
</template>
