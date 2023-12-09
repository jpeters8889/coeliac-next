<script setup lang="ts">
import Card from '@/Components/Card.vue';
import { StarIcon, PencilIcon, FlagIcon } from '@heroicons/vue/24/solid';
import { DetailedEatery } from '@/types/EateryTypes';
import EaterySuggestEditsModal from '@/Components/PageSpecific/EatingOut/Details/Modals/EaterySuggestEditsModal.vue';
import { ref } from 'vue';
import ReportEateryModal from '@/Components/PageSpecific/EatingOut/Details/Modals/ReportEateryModal.vue';

defineProps<{ eatery: DetailedEatery }>();

defineEmits(['goToReview']);

const showEditModal = ref(false);
const showReportPlaceModal = ref(false);
</script>

<template>
  <Card class="space-y-2">
    <h3 class="text-lg font-semibold">Help us improve {{ eatery.name }}</h3>

    <ul class="flex flex-wrap items-center gap-2">
      <li
        class="rounded bg-secondary bg-opacity-25 px-2 py-1 leading-none transition-all hover:bg-opacity-75"
      >
        <a
          class="flex cursor-pointer items-center space-x-2 text-sm font-semibold text-grey transition-all ease-in-out hover:text-black"
          @click.prevent="$emit('goToReview')"
        >
          <StarIcon class="h-4 w-4" />
          <span>Review</span>
        </a>
      </li>

      <li
        class="rounded bg-secondary bg-opacity-25 px-2 py-1 leading-none transition-all hover:bg-opacity-75"
      >
        <a
          class="flex cursor-pointer items-center space-x-2 text-sm font-semibold text-grey transition-all ease-in-out hover:text-black"
          @click.prevent="showEditModal = true"
        >
          <PencilIcon class="h-4 w-4" />
          <span>Edit</span>
        </a>
      </li>

      <li
        class="rounded bg-secondary bg-opacity-25 px-2 py-1 leading-none transition-all hover:bg-opacity-75"
      >
        <a
          class="flex cursor-pointer items-center space-x-2 text-sm font-semibold text-grey transition-all ease-in-out hover:text-black"
          @click.prevent="showReportPlaceModal = true"
        >
          <FlagIcon class="h-4 w-4" />
          <span>Report</span>
        </a>
      </li>
    </ul>
  </Card>

  <EaterySuggestEditsModal
    :eatery-name="eatery.name"
    :eatery-id="eatery.id"
    :show="showEditModal"
    @close="showEditModal = false"
    @open-report="
      showEditModal = false;
      showReportPlaceModal = true;
    "
  />

  <ReportEateryModal
    :eatery-name="eatery.name"
    :eatery-id="eatery.id"
    :show="showReportPlaceModal"
    @close="showReportPlaceModal = false"
  />
</template>
