<script lang="ts" setup>
import { DetailedEatery } from '@/types/EateryTypes';
import EateryHeading from '@/Components/PageSpecific/EatingOut/Details/EateryHeading.vue';
import EateryDescription from '@/Components/PageSpecific/EatingOut/Details/EateryDescription.vue';
import EaterySuggestEdits from '@/Components/PageSpecific/EatingOut/Details/EaterySuggestEdits.vue';
import EateryLocation from '@/Components/PageSpecific/EatingOut/Details/EateryLocation.vue';
import EateryAdminReview from '@/Components/PageSpecific/EatingOut/Details/EateryAdminReview.vue';
import EateryVisitorPhotos from '@/Components/PageSpecific/EatingOut/Details/EateryVisitorPhotos.vue';
import EateryVisitorReviews from '@/Components/PageSpecific/EatingOut/Details/EateryVisitorReviews.vue';
import { ref } from 'vue';

defineProps<{
  eatery: DetailedEatery;
}>();

const forceOpenReport = ref(false);
</script>

<template>
  <EateryHeading :eatery="eatery" />

  <EateryDescription
    :eatery="eatery"
    :open-report="forceOpenReport"
    @reset-force-open="forceOpenReport = false"
  />

  <EaterySuggestEdits
    :id="eatery.id"
    :name="eatery.name"
    @open-report="forceOpenReport = true"
  />

  <EateryLocation
    v-if="eatery.county.id !== 1 || eatery.branch"
    :eatery="eatery"
  />

  <EateryAdminReview
    v-if="eatery.reviews.admin_review"
    :eatery-name="eatery.name"
    :review="eatery.reviews.admin_review"
  />

  <EateryVisitorPhotos
    v-if="eatery.reviews.images?.length > 0"
    :eatery="eatery"
  />

  <EateryVisitorReviews :eatery="eatery" />
</template>
