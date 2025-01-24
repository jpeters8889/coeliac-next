<script setup lang="ts">
import { EateryNationwideBranch } from '@/types/EateryTypes';
import Warning from '@/Components/Warning.vue';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
import Card from '@/Components/Card.vue';
import Sidebar from '@/Components/Overlays/Sidebar.vue';
import StaticMap from '@/Components/Maps/StaticMap.vue';

const props = defineProps<{
  eateryName: string;
  show: boolean;
  branches: EateryNationwideBranch[];
}>();

const emits = defineEmits(['close']);

const close = () => {
  emits('close');
};

const branchName = (branch: EateryNationwideBranch): string => {
  const suffix =
    branch.town.name === branch.county.name
      ? branch.town.name
      : `${branch.town.name}, ${branch.county.name}`;

  const name = branch.name ? branch.name : props.eateryName;

  return `${name}, ${suffix}`;
};
</script>

<template>
  <Sidebar
    :open="show"
    side="right"
    size="lg"
    @close="close()"
  >
    <div class="bg-white">
      <div
        class="border-grey-mid relative border-b bg-grey-light p-3 pr-[34px] text-center text-sm font-semibold"
      >
        {{ eateryName }}'s Branch List
      </div>

      <div class="p-3 flex flex-col space-y-3">
        <Warning>
          <p class="prose-sm max-w-none lg:prose">
            Please note while we take every care to keep this list up to date,
            branches can open and close at any time without warning, please
            check
            {{ eateryName }}'s website for the most accurate information.
          </p>
        </Warning>

        <template
          v-for="branch in branches"
          :key="branch.id"
        >
          <Disclosure
            v-slot="{ open }"
            :as="Card"
            v-bind="{
              theme: 'primary-light',
              faded: true,
              noPadding: true,
              class: 'p-2',
            }"
          >
            <DisclosureButton
              class="flex w-full justify-between rounded-lg focus:outline-hidden"
            >
              <div class="flex flex-col space-y-1">
                <span
                  class="text-left text-primary-dark font-semibold lg:text-lg xl:text-xl"
                  v-text="branchName(branch)"
                />

                <span
                  v-if="!open"
                  class="text-xs text-left lg:text-base"
                  v-text="branch.location.address"
                />
              </div>
              <ChevronDownIcon
                :class="open ? 'rotate-180 transform' : ''"
                class="h-5 w-5 text-primary-dark"
              />
            </DisclosureButton>

            <DisclosurePanel
              class="flex flex-col mt-4 border-t border-primary pt-4"
            >
              <StaticMap
                :lng="branch.location.lng"
                :lat="branch.location.lat"
              />

              <div
                class="font-semibold lg:text-lg"
                v-text="branch.location.address"
              />
            </DisclosurePanel>
          </Disclosure>
        </template>
      </div>
    </div>
  </Sidebar>
</template>
