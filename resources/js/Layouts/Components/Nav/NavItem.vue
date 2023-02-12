<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import { NavigationItem } from '@/types/DefaultProps';

defineProps({
  label: {
    type: String,
    required: true,
  },
  hasDropdown: {
    type: Boolean,
    required: false,
    default: false,
  },
  layout: {
    type: String,
    required: false,
    validator: (value: string) => ['3x5'].includes(value),
    default: '3x5',
  },
  items: {
    type: Array as () => NavigationItem[],
    required: false,
    default: null,
  },
  viewMore: {
    type: String,
    required: false,
    default: null,
  },
  viewMoreLink: {
    type: String,
    required: false,
    default: null,
  },
});
</script>

<template>
  <template v-if="!hasDropdown">
    <a
      href="#"
      class="font-medium flex h-full items-center border-b-2 border-transparent hover:border-white px-4"
      v-text="label"
    />
  </template>

  <template v-else>
    <Popover v-slot="{ open }">
      <PopoverButton
        as="a"
        class="border-b-2 group flex items-center font-medium hover:text-gray-900 h-full cursor-pointer px-4"
        :class="open ? 'border-white' : 'border-transparent hover:border-white'"
      >
        <span v-text="label" />
      </PopoverButton>

      <transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0 -translate-y-1"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-150"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 -translate-y-1"
      >
        <PopoverPanel
          v-if="layout === '3x5'"
          class="absolute inset-x-0 top-full z-10 hidden transform bg-white shadow-lg md:block"
        >
          <div
            class="mx-auto max-w-7xl flex"
          >
            <div class="flex flex-col divide-y divide-secondary w-2/3">
              <template
                v-for="(item, index) in items"
                :key="item.title"
              >
                <Link
                  v-if="index < 3"
                  :href="item.link"
                  class="flex flex-col justify-between rounded-lg p-2 py-4 first:pt-2 last:pb-2 hover:bg-secondary/20"
                >
                  <div class="flex md:h-full">
                    <div class="flex-shrink-0 w-1/5">
                      <img
                        :src="item.image"
                        :alt="item.title"
                      >
                    </div>
                    <div class="ml-4 md:flex md:flex-1 md:flex-col md:justify-between">
                      <div>
                        <p class="text-base font-medium text-gray-900">
                          {{ item.title }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                          {{ item.description }}
                        </p>
                      </div>
                    </div>
                  </div>
                </Link>
              </template>
            </div>

            <div class="flex flex-col w-1/3 p-2 space-y-2">
              <template
                v-for="(item, index) in items"
                :key="item.title"
              >
                <Link
                  v-if="index >= 3"
                  :href="item.link"
                  class="flex flex-col justify-between rounded-lg"
                >
                  {{ item.title }}
                </Link>
              </template>
              <div
                v-if="viewMore"
                class="flex-1 flex items-end"
              >
                <CoeliacButton
                  :label="viewMore"
                  :href="viewMoreLink"
                  size="lg"
                  theme="secondary"
                />
              </div>
            </div>
          </div>
        </PopoverPanel>
      </transition>
    </Popover>
  </template>
</template>
