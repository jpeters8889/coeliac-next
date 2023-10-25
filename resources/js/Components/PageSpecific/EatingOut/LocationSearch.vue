<script setup lang="ts">
import Card from '@/Components/Card.vue';
import { useForm } from '@inertiajs/vue3';
import { FormSelectOption } from '@/Components/Forms/Props';
import FormInput from '@/Components/Forms/FormInput.vue';
import FormSelect from '@/Components/Forms/FormSelect.vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid';
import { Ref, ref, watch } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import axios, { AxiosResponse } from 'axios';
import { DataResponse } from '@/types/GenericTypes';
import Loader from '@/Components/Loader.vue';

const form = useForm<{ term: string; range: 1 | 2 | 5 | 10 | 20 }>({
  term: '',
  range: 2,
});

const rangeOptions: FormSelectOption[] = [
  { label: 'within 1 mile', value: 1 },
  { label: 'within 2 miles', value: 2 },
  { label: 'within 5 miles', value: 5 },
  { label: 'within 10 miles', value: 10 },
  { label: 'within 20 miles', value: 20 },
];

type LocationResult = {
  label: string;
};

const isSearching = ref(false);
const hasSearched = ref(false);
const skipWatcher = ref(false);
const results: Ref<LocationResult[]> = ref([]);

const searchForLocation = useDebounceFn(() => {
  isSearching.value = true;

  axios
    .post('/api/wheretoeat/search', { term: form.term })
    .then((response: AxiosResponse<DataResponse<LocationResult[]>>) => {
      results.value = response.data.data;

      hasSearched.value = true;
      isSearching.value = false;
    });
}, 300);

const selectLocation = (location: string) => {
  skipWatcher.value = true;
  form.term = location;
  hasSearched.value = false;
};

const submitSearch = () => {
  if (form.term.length < 3) {
    return;
  }

  form.post('/wheretoeat/search');
};

watch(
  () => form.term,
  () => {
    if (skipWatcher.value === true) {
      skipWatcher.value = false;

      return;
    }

    if (form.term.length < 3) {
      return;
    }

    searchForLocation();
  }
);
</script>

<template>
  <Card class="flex flex-col space-y-3 !bg-primary-light !bg-opacity-50">
    <p class="prose-md font-weight-bold prose max-w-none">
      Looking for somewhere specific? Search by postcode or town below to get
      places to eat near you!
    </p>

    <form
      class="flex flex-col gap-2 sm:flex-row"
      @submit.prevent="submitSearch()"
    >
      <div class="flex flex-1 flex-col">
        <FormInput
          v-model="form.term"
          type="search"
          label=""
          placeholder="Search..."
          name="term"
          hide-label
        />

        <div
          v-if="hasSearched"
          class="results -mt-2 rounded-b border border-grey-off bg-white"
        >
          <div
            v-if="isSearching"
            class="p-4"
          >
            <Loader
              color="primary"
              :display="true"
              :absolute="false"
            />
          </div>

          <ul
            v-else-if="results.length"
            class="flex flex-col divide-y divide-grey-off"
          >
            <li
              v-for="result in results"
              :key="result.label"
              class="cursor-pointer select-none p-2 text-sm transition-colors hover:bg-grey-off hover:bg-opacity-30"
              @click="selectLocation(result.label)"
              v-text="result.label"
            />
          </ul>

          <span v-else> Sorry, no locations found... </span>
        </div>
      </div>

      <div class="flex space-x-2">
        <FormSelect
          v-model="form.range"
          name="range"
          :options="rangeOptions"
          class="flex-1"
        />

        <CoeliacButton
          type="submit"
          as="button"
          :icon="MagnifyingGlassIcon"
          :loading="form.processing"
          icon-only
          @click="submitSearch()"
        />
      </div>
    </form>
  </Card>
</template>
