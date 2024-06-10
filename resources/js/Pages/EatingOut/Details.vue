<script lang="ts" setup>
import { DetailedEatery } from '@/types/EateryTypes';
import EateryHeading from '@/Components/PageSpecific/EatingOut/Details/EateryHeading.vue';
import EateryDescription from '@/Components/PageSpecific/EatingOut/Details/EateryDescription.vue';
import EateryLocation from '@/Components/PageSpecific/EatingOut/Details/EateryLocation.vue';
import EateryAdminReview from '@/Components/PageSpecific/EatingOut/Details/EateryAdminReview.vue';
import EateryVisitorPhotos from '@/Components/PageSpecific/EatingOut/Details/EateryVisitorPhotos.vue';
import EateryVisitorReviews from '@/Components/PageSpecific/EatingOut/Details/EateryVisitorReviews.vue';
import EateryFeedbackLinks from '@/Components/PageSpecific/EatingOut/Details/EateryFeedbackLinks.vue';
import { Ref, ref } from 'vue';
import EateryFeatures from '@/Components/PageSpecific/EatingOut/Details/EateryFeatures.vue';
import { formatDate } from '@/helpers';

const props = defineProps<{
  eatery: DetailedEatery;
}>();

const reviewsElem: Ref<HTMLDivElement> = ref() as Ref<HTMLDivElement>;

const goToReview = () => {
  reviewsElem.value.scrollIntoView({
    behavior: 'smooth',
  });
};

const eateryName = (): string => {
  if (props.eatery.branch && props.eatery.branch.name) {
    return `${props.eatery.branch.name} - ${props.eatery.name}`;
  }

  return props.eatery.name;
};
</script>

<template>
  <div class="flex flex-col space-y-3 lg:space-y-4 xl:space-y-5">
    <div
      v-if="eatery.closed_down"
      class="bg-red px-3 py-1 text-lg font-semibold text-white"
    >
      This eatery was unfortunately marked as closed down on
      {{ formatDate(eatery.last_updated) }}.
    </div>

    <EateryHeading :eatery="eatery" />

    <EateryFeedbackLinks
      v-if="!eatery.closed_down"
      :eatery="eatery"
      @go-to-review="goToReview()"
    />

    <EateryDescription :eatery="eatery" />

    <EateryFeatures
      v-if="eatery.features && eatery.features.length > 0"
      :name="eateryName()"
      :features="eatery.features"
    />

    <EateryLocation
      v-if="eatery.county.id !== 1 || eatery.branch"
      :eatery="eatery"
    />

    <EateryAdminReview
      v-if="eatery.reviews.admin_review"
      :eatery-name="eateryName()"
      :review="eatery.reviews.admin_review"
    />

    <EateryVisitorPhotos
      v-if="eatery.reviews.images?.length > 0"
      :eatery="eatery"
    />

    <div ref="reviewsElem">
      <EateryVisitorReviews :eatery="eatery" />
    </div>
  </div>
</template>
