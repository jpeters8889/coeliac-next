<script setup lang="ts">
import FormInput from '@/Components/Forms/FormInput.vue';
import { ref } from 'vue';

const search = ref('');
</script>

<template>
  <div class="absolute z-10 w-full p-2">
    <div class="max-w-[calc(100%-35px)] bg-white shadow">
      <FormInput
        v-model="search"
        type="search"
        label=""
        name="search"
        hide-label
        :borders="false"
        placeholder="Search..."
      />
    </div>
  </div>
</template>
