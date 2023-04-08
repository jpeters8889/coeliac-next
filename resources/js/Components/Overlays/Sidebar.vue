<script setup lang="ts">
import {
  Dialog, DialogPanel, TransitionChild, TransitionRoot,
} from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';

const emit = defineEmits(['close']);

defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  side: {
    type: String,
    required: false,
    default: 'left',
    validator: (value: string) => ['left', 'right'].includes(value),
  },
});

const closeOverlay = () => emit('close');
</script>

<template>
  <Teleport to="body">
    <TransitionRoot
      as="template"
      :show="open"
    >
      <Dialog
        as="div"
        class="relative z-50"
        @close="closeOverlay()"
      >
        <TransitionChild
          as="template"
          enter="ease-in-out duration-500"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="ease-in-out duration-500"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity" />
        </TransitionChild>

        <div class="fixed inset-0 overflow-hidden">
          <div class="absolute inset-0 overflow-hidden">
            <div
              class="pointer-events-none fixed inset-y-0 flex max-w-full"
              :class="side === 'left' ? 'left-0 pr-10' : 'right-0 pl-10'"
            >
              <TransitionChild
                as="template"
                enter="transform transition ease-in-out duration-500 sm:duration-700"
                :enter-from="side === 'left' ? '-translate-x-full' : 'translate-x-full'"
                enter-to="translate-x-0"
                leave="transform transition ease-in-out duration-500 sm:duration-700"
                leave-from="translate-x-0"
                :leave-to="side === 'left' ? '-translate-x-full' : 'translate-x-full'"
              >
                <DialogPanel class="pointer-events-auto relative w-screen max-w-xs">
                  <TransitionChild
                    as="template"
                    enter="ease-in-out duration-500"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in-out duration-500"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                  >
                    <div
                      class="absolute top-0 flex pt-4"
                      :class="side === 'left' ? 'right-0 -mr-8 pl-2 sm:-mr-10 sm:pl-4' : 'left-0 -ml-8 pr-2 sm:-ml-10 sm:pr-4'"
                    >
                      <button
                        type="button"
                        class="rounded-md text-gray-300 hover:text-white focus:outline-none"
                        @click="closeOverlay()"
                      >
                        <XMarkIcon
                          class="h-6 w-6"
                          aria-hidden="true"
                        />
                      </button>
                    </div>
                  </TransitionChild>
                  <div class="flex h-full flex-col overflow-y-scroll shadow-xl">
                    <slot />
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </Teleport>
</template>
