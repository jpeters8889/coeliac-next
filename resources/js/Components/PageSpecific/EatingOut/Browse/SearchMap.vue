<script setup lang="ts">
import FormInput from '@/Components/Forms/FormInput.vue';
import { ref, watch } from 'vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import axios, { AxiosResponse } from 'axios';
import { LatLng } from '@/types/EateryTypes';

const search = ref('');
const hasError = ref(false);

const emits = defineEmits(['loading', 'navigate-to']);

const handleSearch = () => {
  if (search.value.length < 3) {
    hasError.value = true;
    return;
  }

  hasError.value = false;

  emits('loading');

  axios
    .post('/api/wheretoeat/browse/search', { term: search.value })
    .then((response: AxiosResponse<LatLng>) => {
      emits('navigate-to', response.data);
    });
};

watch(hasError, (check) => {
  if (check) {
    setTimeout(() => {
      hasError.value = false;
    }, 3000);
  }
});
</script>

<template>
  <div class="absolute z-10 w-full p-2">
    <div>
      <form
        class="flex w-[calc(100%-35px)] max-w-lg items-center gap-2 rounded-md bg-white shadow"
        :class="hasError ? 'border border-red' : ''"
        @submit.prevent="handleSearch()"
      >
        <FormInput
          v-model="search"
          type="search"
          label=""
          name="search"
          hide-label
          :borders="false"
          placeholder="Search..."
          size="large"
          class="flex-1"
        />

        <button
          class="mr-1 flex h-8 w-8 items-center justify-center rounded-full"
          :class="hasError ? 'bg-red' : 'bg-primary'"
          @click.prevent="handleSearch()"
        >
          <MagnifyingGlassIcon class="h-5 w-5" />
        </button>
      </form>
    </div>

    <div
      class="mt-1 w-[calc(100%-35px)] max-w-lg rounded-md bg-red bg-opacity-70 p-1 text-sm font-semibold leading-none text-white shadow transition-all"
      :class="hasError ? 'opacity-100' : 'opacity-0'"
    >
      Please insert at least 3 characters...
    </div>
  </div>
</template>
