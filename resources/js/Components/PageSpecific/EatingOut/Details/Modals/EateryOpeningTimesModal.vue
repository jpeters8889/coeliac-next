<script setup lang="ts">
import { Days, DetailedEatery, OpeningTime } from '@/types/EateryTypes';
import Modal from '@/Components/Overlays/Modal.vue';
import { ucfirst } from '@/helpers';

const props = defineProps<{
  eateryName: string;
  openingTimes: DetailedEatery['opening_times'];
  show: boolean;
}>();

const days: Days[] = [
  'monday',
  'tuesday',
  'wednesday',
  'thursday',
  'friday',
  'saturday',
  'sunday',
];

const isOpenOn = (day: Days): boolean => !!props.openingTimes?.days[day].opens;

const openingTimesFor = (day: Days): OpeningTime =>
  props.openingTimes?.days[day] as OpeningTime;

const openingTimeToString = (day: Days): string => {
  const openingTimes = openingTimesFor(day);

  return `${openingTimes.opens} - ${openingTimes.closes}`;
};

defineEmits(['close']);
</script>

<template>
  <Modal
    :open="show"
    @close="$emit('close')"
  >
    <div
      class="border-grey-mid relative border-b bg-grey-light p-3 pr-[34px] text-center text-sm font-semibold"
      v-html="`Opening Times for ${eateryName}`"
    />
    <div class="p-4">
      <ul class="space-y-2">
        <li
          v-for="(day, index) in days"
          :key="index"
          class="flex justify-between"
        >
          <span class="mr-4">{{ ucfirst(day) }}</span>
          <span
            v-if="isOpenOn(day)"
            v-text="openingTimeToString(day)"
          />
          <span v-else>Closed</span>
        </li>
      </ul>
    </div>
  </Modal>
</template>
