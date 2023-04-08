<script lang="ts" setup>
import { computed } from 'vue';

const props = defineProps({
  name: {
    type: String,
    required: true,
  },
});

const filepath = `../../icons/${props.name}.svg`;

const modules = import.meta.glob('../../icons/*.svg', {
  as: 'raw',
  eager: true,
});

const svg = computed(() => modules[filepath]);
</script>

<template>
  <div v-html="svg" />
</template>
