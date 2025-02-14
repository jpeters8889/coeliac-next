<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { AdjustmentsHorizontalIcon } from '@heroicons/vue/24/solid';
import Sidebar from '@/Components/Overlays/Sidebar.vue';
import TownFilterSidebarContent from '@/Components/PageSpecific/EatingOut/Town/TownFilterSidebarContent.vue';
import axios, { AxiosResponse } from 'axios';
import {
  EateryFilterItem,
  EateryFilterKeys,
  EateryFilters,
} from '@/types/EateryTypes';
import { DataResponse } from '@/types/GenericTypes';

const props = defineProps<{
  setFilters: Partial<{ [T in EateryFilterKeys]?: string[] }>;
}>();

const viewSidebar = ref(false);
const filters = ref<EateryFilters>();

const emits = defineEmits(['filtersUpdated']);

const getFilters = () => {
  axios
    .get('/api/wheretoeat/features')
    .then((response: AxiosResponse<DataResponse<EateryFilters>>) => {
      const defaultFilters = response.data.data;

      if (props.setFilters) {
        const keys: EateryFilterKeys[] = [
          'categories',
          'venueTypes',
          'features',
        ];

        keys.forEach((key) => {
          props.setFilters[key]?.forEach((category: string) => {
            const index = defaultFilters[key].indexOf(
              defaultFilters[key].find(
                (filter) => filter.value === category,
              ) as EateryFilterItem,
            );

            defaultFilters[key][index].checked = true;
          });
        });
      }

      filters.value = defaultFilters;

      emits('filtersUpdated', { filters: filters.value });
    });
};

onMounted(() => {
  if (filters.value) {
    return;
  }

  getFilters();
});
</script>

<template>
  <div
    v-show="filters"
    class="group absolute bottom-0 right-0 z-10 p-4 md:p-6"
  >
    <div
      class="absolute left-0 ml-[-10px] mt-[-28px] rounded-full border-2 border-white bg-secondary px-4 py-1 text-sm font-semibold uppercase leading-none opacity-0 transition-all duration-300 group-hover:opacity-70 group-hover:delay-500 md:ml-[8px] xmd:ml-[10px] xmd:mt-[-38px] xmd:text-base"
    >
      Filter
    </div>

    <div
      class="-ml-3 cursor-pointer rounded-full border-2 border-white bg-secondary p-3 text-white shadow-sm transition md:shadow-lg"
    >
      <AdjustmentsHorizontalIcon
        class="h-8 w-8 md:max-xmd:h-12 md:max-xmd:w-12 xmd:h-14 xmd:w-14"
        @click="viewSidebar = true"
      />
    </div>
  </div>

  <Sidebar
    :open="viewSidebar"
    side="right"
    @close="viewSidebar = false"
  >
    <TownFilterSidebarContent
      :filters="filters as EateryFilters"
      @updated="$emit('filtersUpdated', $event)"
    />
  </Sidebar>
</template>
