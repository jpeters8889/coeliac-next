<script lang="ts" setup>
import {
  EateryReview,
  StarRating as StarRatingType,
} from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';
import { computed, ref } from 'vue';
import StarRating from '@/Components/StarRating.vue';
import ReviewImageGallery from '@/Components/PageSpecific/EatingOut/Shared/ReviewImageGallery.vue';
import { ucfirst, formatDate } from '@/helpers';

const props = defineProps<{
  eateryName: string;
  review: EateryReview;
}>();

const hasRatings = computed(() => {
  if (props.review?.expense) {
    return true;
  }

  if (props.review?.food_rating) {
    return true;
  }

  if (props.review?.service_rating) {
    return true;
  }

  return false;
});

const howExpensive = () => {
  let rtr = '';

  for (
    let x = 0;
    x < parseInt(<string>props.review.expense?.value, 10);
    x += 1
  ) {
    rtr += '£';
  }

  return `<strong>${rtr}</strong> - ${props.review.expense?.label}`;
};
</script>

<template>
  <Card
    no-padding
    class="sm:flex-row"
  >
    <div
      class="hidden w-1/3 max-w-[250px] flex-col bg-primary-lightest sm:flex md:w-1/4"
    >
      <div class="flex h-8 items-center px-3">
        <StarRating
          :rating="<StarRatingType>review.rating"
          size="w-4 h-4"
          show-all
        />
      </div>

      <div
        class="flex flex-1 flex-col border-r border-grey-off px-3 pb-3 pt-0"
        :class="hasRatings ? 'justify-between' : 'justify-end'"
      >
        <ul
          v-if="hasRatings"
          class="mb-2 flex flex-1 flex-col space-y-px text-sm"
        >
          <li
            v-if="review.expense"
            v-html="howExpensive()"
          />
          <li v-if="review.food_rating">
            Food: {{ ucfirst(review.food_rating) }}
          </li>
          <li v-if="review.service_rating">
            Service: {{ ucfirst(review.service_rating) }}
          </li>
        </ul>

        <ul class="flex flex-col space-y-px text-xs">
          <li v-if="review.name">
            {{ review.name }}
          </li>
          <li>
            {{ formatDate(review.published) }}
          </li>
        </ul>
      </div>
    </div>

    <div class="flex w-full flex-1 flex-col">
      <div
        class="flex items-center justify-between border-b border-grey-off bg-primary-lightest px-3 py-1 text-sm sm:h-8 sm:justify-end"
      >
        <div class="sm:hidden">
          <StarRating
            :rating="<StarRatingType>review.rating"
            size="w-4 h-4"
            show-all
          />
        </div>

        <span v-text="review.date_diff" />
      </div>

      <div class="space-y-3 p-3">
        <template v-if="review.body">
          <div class="flex flex-col space-y-2">
            <p
              class="md:prose-md prose max-w-none"
              v-html="review.body"
            />

            <p v-if="review.branch_name">
              Review from <strong>{{ review.branch_name }}</strong> branch.
            </p>

            <ReviewImageGallery
              :images="review.images"
              :eatery-name="eateryName"
            />
          </div>
        </template>
        <p
          v-else
          class="italic"
          v-text="`Reviewer didn't leave a comment...`"
        />
      </div>

      <div
        class="flex items-center justify-between border-t border-grey-off bg-primary-lightest px-3 py-1 text-sm sm:hidden"
      >
        <span>{{ review.name || '' }}</span>
        <span>{{ formatDate(review.published) }}</span>
      </div>
    </div>
  </Card>
</template>
