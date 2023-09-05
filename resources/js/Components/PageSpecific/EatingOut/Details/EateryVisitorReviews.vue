<script lang="ts" setup>
import { DetailedEatery, EateryReview } from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';
import { computed, ref } from 'vue';
import EateryAddReview from '@/Components/PageSpecific/EatingOut/Details/Reviews/EateryAddReview.vue';
import EateryVisitorReview from '@/Components/PageSpecific/EatingOut/Details/Reviews/EateryVisitorReview.vue';

const props = defineProps<{
  eatery: DetailedEatery;
}>();

const hasJustBeenRated = ref(false);

const reviews = computed(
  (): EateryReview[] => props.eatery.reviews.user_reviews
);
</script>

<template>
  <Card class="space-y-2">
    <div class="page-box space-y-3">
      <h2 class="text-xl font-semibold">
        Your Reviews ({{ reviews.length || 0 }})
      </h2>

      <p
        class="rounded-lg border border-primary bg-primary bg-opacity-20 p-2 text-sm"
      >
        All the reviews and ratings below have been submitted by visitors to our
        website and App, ratings are applied straight away but text reviews must
        be validated by an admin before they are visible.
      </p>
    </div>
  </Card>

  <EateryAddReview :eatery="eatery" />

  <Card v-if="hasJustBeenRated">
    <p>
      Thank you for leaving your review of <strong>{{ eatery.name }}</strong>
    </p>
  </Card>

  <template v-if="reviews.length">
    <EateryVisitorReview
      v-for="review in reviews"
      :key="review.id"
      :eatery-name="eatery.name"
      :review="review"
    />
  </template>
</template>
