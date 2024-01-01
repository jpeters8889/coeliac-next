<script setup lang="ts">
import { PaginatedResponse } from '@/types/GenericTypes';
import { ShopProductRating, ShopProductReview } from '@/types/Shop';
import StarRating from '@/Components/StarRating.vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import { ref, watch } from 'vue';

const props = defineProps<{
  productName: string;
  reviews: PaginatedResponse<ShopProductReview>;
  rating: ShopProductRating;
}>();

const loading = ref(false);

watch(props.reviews, () => {
  loading.value = false;
});

defineEmits(['load-more']);
</script>

<template>
  <div class="bg-white">
    <div class="mx-auto md:grid md:grid-cols-3 md:gap-x-8 xl:grid-cols-4">
      <div class="">
        <div class="mt-3 flex items-center space-x-2">
          <div>
            <div class="flex items-center">
              <StarRating
                :rating="rating.average"
                show-all
              />
            </div>
          </div>
          <p class="text-right text-sm">Based on {{ rating.count }} reviews</p>
        </div>

        <div class="mt-6">
          <dl class="space-y-3">
            <div
              v-for="count in rating.breakdown"
              :key="count.rating"
              class="flex items-center text-sm"
            >
              <dt class="flex flex-1 items-center">
                <p class="w-3 font-semibold">
                  {{ count.rating }}
                </p>

                <div class="ml-1 flex flex-1 items-center">
                  <StarRating
                    :rating="1"
                    size="w-4 h-4"
                  />

                  <div class="relative ml-3 flex-1">
                    <div
                      class="h-3 rounded-full border border-gray-200 bg-gray-100"
                    />

                    <div
                      v-if="count.count > 0"
                      class="bordbg-secondary absolute inset-y-0 rounded-full border bg-secondary"
                      :style="{
                        width: `calc(${count.count} / ${rating.count} * 100%)`,
                      }"
                    />
                  </div>
                </div>
              </dt>

              <dd
                class="ml-3 w-10 text-right text-sm tabular-nums text-gray-900"
              >
                {{ Math.round((count.count / rating.count) * 100) }}%
              </dd>
            </div>
          </dl>
        </div>

        <div class="mt-10 space-y-3">
          <h3 class="text-lg font-semibold">Share your thoughts</h3>

          <p class="text-sm">
            Have you used our <strong v-text="productName" />? Share your
            thoughts with other customers!
          </p>

          <CoeliacButton
            label="Write a review"
            theme="light"
            size="xl"
          />
        </div>
      </div>

      <div class="mt-8 md:col-span-2 md:mt-0 xl:col-span-3">
        <div class="flow-root">
          <div class="-my-6 divide-y divide-gray-200">
            <div
              v-for="review in reviews.data"
              :key="review.name"
              class="py-6"
            >
              <div class="flex items-center justify-between">
                <h4
                  class="font-bold lg:text-xl"
                  v-text="review.name"
                />

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
                  review.review
                    ? review.review
                    : `<em>Customer didn't leave a review with their rating</em>`
                "
              />
            </div>

            <CoeliacButton
              v-if="reviews.links.next"
              label="Load more reviews..."
              size="xl"
              theme="light"
              :loading="loading"
              @click="
                loading = true;
                $emit('load-more');
              "
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
