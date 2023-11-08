<template>
  <div
    class="flex p-1"
    :class="field.direction === 'column' ? 'flex-col' : 'flex-wrap'"
  >
    <div
      v-for="(subField, index) in field.fields"
      :key="subField.uniqueKey"
      class="flex p-1"
      :class="field.direction === 'column' ? 'w-full' : 'w-1/5'"
    >
      <div class="item w-full rounded-lg">
        <Component
          :is="`form-${subField.component}`"
          :field="parseField(subField)"
          :index="index"
        />
      </div>
    </div>
  </div>
</template>

<style>
.item {
  background-color: rgba(var(--colors-gray-200), 0.3);
}

.dark .item {
  background-color: rgba(var(--colors-gray-700), 0.3);
}
</style>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import { each } from 'lodash/collection';
import tap from 'lodash/tap';

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || '';
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      const fields = tap(new FormData(), (fieldData) => {
        each(this.field.fields, (field) => {
          field.fill(fieldData);
        });
      });

      const parsedFields = {};

      // eslint-disable-next-line no-return-assign
      fields.forEach((value, key) => (parsedFields[key] = value));

      formData.append(this.field.attribute, JSON.stringify(parsedFields));
    },

    parseField(field) {
      if (this.field.direction === 'row') {
        field.stacked = true;
      }

      return field;
    },
  },
};
</script>
