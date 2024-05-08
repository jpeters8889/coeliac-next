<script lang="ts" setup>
import { DetailedEatery, EateryReview } from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';
import { computed, ComputedRef, ref } from 'vue';
import StarRating from '@/Components/StarRating.vue';
import { formatDate, ucfirst } from '@/helpers';
import RatingsBreakdown from '@/Components/PageSpecific/Shared/RatingsBreakdown.vue';
import FormCheckbox from '@/Components/Forms/FormCheckbox.vue';
import Modal from '@/Components/Overlays/Modal.vue';
import EateryAddReview from '@/Components/PageSpecific/EatingOut/Details/Reviews/EateryAddReview.vue';

const props = defineProps<{
  eatery: DetailedEatery;
}>();

const hideReviewsWithoutBody = ref(true);

const reviews: ComputedRef<EateryReview[]> = computed(
  () => props.eatery.reviews.user_reviews,
);

const filteredReviews: ComputedRef<EateryReview[]> = computed(() => {
  if (!hideReviewsWithoutBody.value) {
    return reviews.value;
  }

  return reviews.value.filter((review) => review.body);
});

const displayAddReviewModal = ref(false);

const reviewHasRatings = (review: EateryReview): boolean => {
  if (review?.expense) {
    return true;
  }

  if (review?.food_rating) {
    return true;
  }

  if (review?.service_rating) {
    return true;
  }

  return false;
};

const howExpensive = (review: EateryReview) => {
  let rtr = '';

  for (let x = 0; x < parseInt(<string>review.expense?.value, 10); x += 1) {
    rtr += '£';
  }

  return `<strong>Price ${rtr}</strong> - ${review.expense?.label}`;
};
</script>

<template>
  <Card>
    <div class="mx-auto md:grid md:grid-cols-3 md:gap-x-8 xl:grid-cols-4">
      <RatingsBreakdown
        :average="eatery.reviews.average"
        :breakdown="eatery.reviews.ratings"
        :count="eatery.reviews.number"
        :can-add-review="!eatery.closed_down"
        @create-review="displayAddReviewModal = true"
      >
        Have you visited <strong v-text="eatery.name" />? Share your experience
        with other people!
      </RatingsBreakdown>

      <div class="mt-8 md:col-span-2 md:mt-0 xl:col-span-3">
        <div class="flow-root">
          <div
            class="mb-2 w-auto rounded bg-primary-light bg-opacity-50 px-3 py-1"
          >
            <FormCheckbox
              v-model="hideReviewsWithoutBody"
              name="hide-ratings"
              label="Hide ratings without a review"
            />
          </div>

          <div class="-my-6 divide-y divide-gray-200">
            <template
              v-if="!hideReviewsWithoutBody || filteredReviews.length > 0"
            >
              <div
                v-for="review in filteredReviews"
                :key="review.id"
                class="py-6"
              >
                <div class="flex items-center justify-between">
                  <div class="flex flex-col">
                    <h4
                      class="font-bold lg:text-xl"
                      v-text="review.body ? review.name : 'Anonymous'"
                    />
                    <time
                      :datetime="review.published"
                      :title="
                        formatDate(review.published, 'Do MMM YYYY h:mm a')
                      "
                      v-text="review.date_diff"
                    />
                  </div>

                  <div class="mt-1 flex items-center">
                    <StarRating
                      :rating="review.rating"
                      size="w-4 h-4 xs:w-5 xs:h-5"
                      show-all
                    />
                  </div>
                </div>

                <div
                  class="prose mt-2 max-w-none lg:prose-lg"
                  v-html="
                    review.body
                      ? review.body
                      : `<em>Customer didn't leave a review with their rating</em>`
                  "
                />

                <div>
                  <ul
                    v-if="reviewHasRatings(review)"
                    class="mt-3 grid grid-cols-1 gap-3 xs:grid-cols-3"
                  >
                    <li
                      v-if="review.expense"
                      class="block rounded bg-primary-light bg-opacity-50 px-3 py-1 leading-none"
                      v-html="howExpensive(review)"
                    />
                    <li
                      v-if="review.food_rating"
                      class="block rounded bg-primary-light bg-opacity-50 px-2 py-1 leading-none"
                    >
                      <strong>Food:</strong> {{ ucfirst(review.food_rating) }}
                    </li>
                    <li
                      v-if="review.service_rating"
                      class="block rounded bg-primary-light bg-opacity-50 px-2 py-1 leading-none"
                    >
                      <strong>Service:</strong>
                      {{ ucfirst(review.service_rating) }}
                    </li>
                  </ul>
                </div>
              </div>
            </template>

            <div
              v-else
              class="py-6 text-lg"
            >
              No reviews found...
            </div>
          </div>
        </div>
      </div>
    </div>

    <Modal
      :open="displayAddReviewModal"
      size="large"
      @close="displayAddReviewModal = false"
    >
      <EateryAddReview :eatery="eatery" />
    </Modal>
  </Card>
</template>
