<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <div>
        <div class="flex items-center space-x-3">
          <span>Unknown / Not Set</span>

          <input
            type="checkbox"
            class="checkbox"
            :checked="value === null"
            @click="noOpeningTimes()"
          />
        </div>

        <template v-if="value !== null">
          <div
            v-for="day in days"
            :key="day"
            class="flex items-center justify-between space-y-2"
          >
            <label>{{ ucfirst(day) }}</label>
            <div class="flex items-center space-x-2">
              <div>
                Closed
                <input
                  type="checkbox"
                  class="checkbox"
                  :checked="!value[day]"
                  @click="toggleDay(day)"
                />
              </div>
              <template v-if="value[day]">
                <div class="flex space-x-1">
                  <select
                    v-model="value[day][0][0]"
                    class="form-control form-input-bordered form-input w-auto"
                  >
                    <option
                      v-for="hour in hours"
                      :key="hour.value"
                      :value="hour.value"
                    >
                      {{ hour.label }}
                    </option>
                  </select>

                  <select
                    v-model="value[day][0][1]"
                    class="form-control form-input-bordered form-input w-auto"
                  >
                    <option
                      v-for="minute in minutes"
                      :key="minute.value"
                      :value="minute.value"
                    >
                      {{ minute.label }}
                    </option>
                  </select>
                </div>

                <span>-</span>

                <div class="flex space-x-1">
                  <select
                    v-model="value[day][1][0]"
                    class="form-control form-input-bordered form-input w-auto"
                  >
                    <option
                      v-for="hour in hours"
                      :key="hour.value"
                      :value="hour.value"
                    >
                      {{ hour.label }}
                    </option>
                  </select>

                  <select
                    v-model="value[day][1][1]"
                    class="form-control form-input-bordered form-input w-auto"
                  >
                    <option
                      v-for="minute in minutes"
                      :key="minute.value"
                      :value="minute.value"
                    >
                      {{ minute.label }}
                    </option>
                  </select>
                </div>
              </template>
            </div>
          </div>
        </template>
      </div>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  computed: {
    days() {
      return Object.keys(this.value);
    },

    hours() {
      return Array.from({ length: 24 }).map((value, hour) => ({
        value: hour,
        label: (hour < 10 ? '0' : '') + hour.toString(),
      }));
    },

    minutes() {
      return [
        { value: 0, label: '00' },
        { value: 15, label: '15' },
        { value: 30, label: '30' },
        { value: 45, label: '45' },
      ];
    },
  },

  methods: {
    setInitialValue() {
      this.value = null;

      if (this.resourceId && this.field.value !== null) {
        this.value = this.field.value;
      }
    },

    fill(formData) {
      formData.append(this.field.attribute, JSON.stringify(this.value));
    },

    ucfirst(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    },

    toggleDay(day) {
      if (this.value[day]) {
        this.value[day] = null;

        return;
      }

      this.value[day] = [
        [0, 0, 0],
        [0, 0, 0],
      ];
    },

    defaultValue() {
      return {
        monday: [
          [0, 0, 0],
          [0, 0, 0],
        ],
        tuesday: [
          [0, 0, 0],
          [0, 0, 0],
        ],
        wednesday: [
          [0, 0, 0],
          [0, 0, 0],
        ],
        thursday: [
          [0, 0, 0],
          [0, 0, 0],
        ],
        friday: [
          [0, 0, 0],
          [0, 0, 0],
        ],
        saturday: [
          [0, 0, 0],
          [0, 0, 0],
        ],
        sunday: [
          [0, 0, 0],
          [0, 0, 0],
        ],
      };
    },

    noOpeningTimes() {
      if (this.value) {
        this.value = null;

        return;
      }

      this.value = this.defaultValue();
    },
  },
};
</script>
