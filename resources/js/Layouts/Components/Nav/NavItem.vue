<script setup lang="ts">
import {
  ChartBarIcon, CursorArrowRaysIcon, ShieldCheckIcon, Squares2X2Icon,
} from '@heroicons/vue/24/outline';
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';

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
});

const solutions = [
  {
    name: 'Analytics',
    description: 'Get a better understanding of where your traffic is coming from.',
    href: '#',
    icon: ChartBarIcon,
  },
  {
    name: 'Engagement',
    description: 'Speak directly to your customers in a more meaningful way.',
    href: '#',
    icon: CursorArrowRaysIcon,
  },
  {
    name: 'Security', description: 'Your customers\' data will be safe and secure.', href: '#', icon: ShieldCheckIcon,
  },
  {
    name: 'Integrations',
    description: 'Connect with third-party tools that you\'re already using.',
    href: '#',
    icon: Squares2X2Icon,
  },
];

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
        <PopoverPanel class="absolute inset-x-0 top-full z-10 hidden transform bg-white shadow-lg md:block">
          <div
            class="mx-auto grid max-w-7xl gap-y-6 px-4 py-6 sm:grid-cols-2 sm:gap-8 sm:px-6 sm:py-8 lg:grid-cols-4 lg:px-8 lg:py-12 xl:py-16"
          >
            <a
              v-for="item in solutions"
              :key="item.name"
              :href="item.href"
              class="-m-3 flex flex-col justify-between rounded-lg p-3 hover:bg-gray-50"
            >
              <div class="flex md:h-full lg:flex-col">
                <div class="flex-shrink-0">
                  <span
                    class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-indigo-500 text-white sm:h-12 sm:w-12"
                  >
                    <component
                      :is="item.icon"
                      class="h-6 w-6"
                      aria-hidden="true"
                    />
                  </span>
                </div>
                <div class="ml-4 md:flex md:flex-1 md:flex-col md:justify-between lg:ml-0 lg:mt-4">
                  <div>
                    <p class="text-base font-medium text-gray-900">{{ item.name }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ item.description }}</p>
                  </div>
                  <p class="mt-2 text-sm font-medium text-indigo-600 lg:mt-4">
                    Learn more
                    <span aria-hidden="true"> &rarr;</span>
                  </p>
                </div>
              </div>
            </a>
          </div>
        </PopoverPanel>
      </transition>
    </Popover>
  </template>
</template>
