<template>
  <div class="flex space-x-2">
    <span
      v-if="field.label"
      v-text="fieldValue.name"
    />
    <img
      :src="`https://flagcdn.com/32x24/${fieldValue.code.toLowerCase()}.png`"
      :width="field.label ? 24 : 32"
      :height="field.label ? 18 : 24"
    />
  </div>
</template>

<script>
export default {
  props: ['resourceName', 'field'],

  computed: {
    fieldValue() {
      return this.field.displayedAs || this.field.value;
    },
  },
};
</script>
