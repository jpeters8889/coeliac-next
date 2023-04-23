<script setup lang="ts">
import {
  Dialog, DialogPanel, TransitionChild, TransitionRoot,
} from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { useSlots } from 'vue';

const emit = defineEmits(['close']);

defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  closeable: {
    required: false,
    type: Boolean,
    default: true,
  },
  noPadding: {
    required: false,
    type: Boolean,
    default: false,
  },
  size: {
    required: false,
    type: String,
    default: 'medium',
    validator: (value: string) => ['small', 'medium', 'large', 'xl', 'full'].includes(value),
  },
});

const closeOverlay = () => emit('close');

const slots = useSlots();
</script>

<template>
  <Teleport to="body">
    <TransitionRoot
      as="template"
      :show="open"
    >
      <Dialog
        as="div"
        class="relative z-10"
        @close="closeOverlay()"
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
          <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
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
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8"
                :class="{
                  'sm:max-w-lg': size === 'medium',
                  'sm:max-w-[95%]': size === 'full',
                }"
              >
                <div
                  class="absolute right-0 top-0 pr-2 pt-2"
                  :class="{hidden: !closeable}"
                >
                  <button
                    type="button"
                    class="rounded-md bg-white bg-opacity-40 text-gray-dark hover:bg-opacity-80"
                    @click="closeOverlay()"
                  >
                    <XMarkIcon class="h-6 w-6" />
                  </button>
                </div>

                <div :class="{'p-2': !noPadding}">
                  <slot />
                </div>

                <div
                  v-if="slots.footer"
                  class="bg-grey-off-light p-2 border-t border-grey-off"
                >
                  <slot name="footer" />
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </Teleport>
</template>
