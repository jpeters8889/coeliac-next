<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { AdjustmentsHorizontalIcon } from '@heroicons/vue/24/solid';
import Sidebar from '@/Components/Overlays/Sidebar.vue';
import TownFilterSidebarContent from '@/Components/PageSpecific/EatingOut/Town/TownFilterSidebarContent.vue';
import axios, { AxiosResponse } from 'axios';
import { EateryFilters } from '@/types/EateryTypes';
import { DataResponse } from '@/types/GenericTypes';

const viewSidebar = ref(false);
const filters = ref();

defineEmits(['filtersUpdated']);

const getFilters = () => {
  axios
    .get('/api/wheretoeat/features')
    .then((response: AxiosResponse<DataResponse<EateryFilters>>) => {
      filters.value = response.data.data;
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
    class="absolute bottom-0 right-0 z-10 p-4 xmd:hidden"
  >
    <div
      class="-ml-3 rounded-full border-2 border-white bg-primary p-3 text-white shadow transition"
    >
      <AdjustmentsHorizontalIcon
        class="h-8 w-8"
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
      :filters="filters"
      @updated="$emit('filtersUpdated', $event)"
    />
  </Sidebar>
</template>
