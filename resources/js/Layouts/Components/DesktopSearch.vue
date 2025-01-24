<script setup lang="ts">
import FormInput from '@/Components/Forms/FormInput.vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import useSearch from '@/composables/useSearch';

const { hasError, searchForm, submitSearch } = useSearch();
</script>

<template>
  <form
    class="flex-col space-y-2 mt-8 hidden items-center pr-2 transition md:flex"
    @submit.prevent="submitSearch()"
  >
    <div
      class="flex w-full rounded-xl bg-white/50 focus-within:bg-white/90 pr-2"
    >
      <FormInput
        v-model="searchForm.q"
        label=""
        type="search"
        name="q"
        :background="false"
        placeholder="Search..."
        class="flex-1"
        hide-label
      />

      <button>
        <MagnifyingGlassIcon class="h-6 w-6" />
      </button>
    </div>

    <p
      v-if="hasError"
      class="text-red font-semibold text-right leading-none"
    >
      Please enter at least 3 characters to search!
    </p>
  </form>
</template>
