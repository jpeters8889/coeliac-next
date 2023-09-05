<script lang="ts" setup>
import {
  EateryReview,
  StarRating as StarRatingType,
} from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';
import { computed, ref } from 'vue';
import StarRating from '@/Components/StarRating.vue';
import ReviewImageGallery from '@/Components/PageSpecific/EatingOut/Shared/ReviewImageGallery.vue';
import { ucfirst } from '../../../../helpers';

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

const displayFullReview = ref(false);

const reviewBody = computed(() => {
  let { body } = props.review;

  if (body && body.length > 500 && !displayFullReview.value) {
    body = `${body.substring(0, body.indexOf(' ', 500))}...`;
  }

  return body?.replaceAll('\n', '<br />');
});
</script>

<template>
  <Card class="space-y-2">
    <h3 class="text-lg font-semibold">Our Review</h3>

    <div class="flex flex-col space-y-2">
      <ul
        v-if="hasRatings"
        class="mb-2 flex flex-1 flex-col space-y-1 rounded border border-primary bg-primary-light bg-opacity-25 p-1 text-sm xs:flex-row xs:justify-around xs:space-y-0"
      >
        <li class="text-md mb-2 flex items-center space-x-1">
          <strong>Our Rating</strong>
          <StarRating
            :rating="<StarRatingType>review.rating"
            size="w-4 h-4"
            show-all
          />
        </li>

        <li
          v-if="review.expense"
          v-html="howExpensive()"
        />
        <li v-if="review.food_rating">
          <strong>Food</strong>: {{ ucfirst(review.food_rating) }}
        </li>
        <li v-if="review.service_rating">
          <strong>Service</strong>: {{ ucfirst(review.service_rating) }}
        </li>
      </ul>

      <p
        class="md:prose-md prose max-w-none"
        v-html="reviewBody"
      />

      <template v-if="review.body?.length > 500 && !displayFullReview">
        <a
          class="cursor-pointer text-lg font-semibold text-primary-dark hover:underline"
          @click.prevent="displayFullReview = true"
          >Read our full review!</a
        >
      </template>

      <div
        v-if="review.images"
        class="flex flex-col rounded border border-primary bg-primary-light bg-opacity-25 p-2"
      >
        <p class="text-md font-semibold">Our Photos</p>

        <ReviewImageGallery
          :images="review.images"
          :eatery-name="eateryName"
          with-margin
        />
      </div>
    </div>
  </Card>
</template>
