<script lang="ts" setup>
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { useSlots } from 'vue';

const emit = defineEmits(['close']);

withDefaults(
  defineProps<{
    open: boolean;
    closeable?: boolean;
    noPadding?: boolean;
    size?: 'small' | 'medium' | 'large' | 'xl' | 'full';
    width?: 'w-full' | 'w-auto';
  }>(),
  {
    closeable: true,
    noPadding: false,
    size: 'medium',
    width: 'w-auto',
  },
);

const closeOverlay = () => emit('close');

const slots = useSlots();
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
                :class="{
                  [width]: true,
                  'xs:max-w-md': size === 'small',
                  'sm:max-w-lg': size === 'medium',
                  'sm:max-w-8xl': size === 'large',
                  'sm:max-w-[95%]': size === 'full',
                }"
                class="relative w-auto max-w-[95%] transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8"
              >
                <div
                  :class="{ hidden: !closeable }"
                  class="absolute right-0 top-0 z-50 pr-2 pt-2"
                >
                  <button
                    class="rounded-md border border-transparent bg-white bg-opacity-40 text-grey-dark hover:border-grey-dark hover:bg-opacity-80"
                    type="button"
                    @click="closeOverlay()"
                  >
                    <XMarkIcon class="h-6 w-6" />
                  </button>
                </div>

                <div :class="{ 'p-2': !noPadding }">
                  <slot />
                </div>

                <div
                  v-if="slots.footer"
                  class="border-t border-grey-off bg-grey-off-light p-2"
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
