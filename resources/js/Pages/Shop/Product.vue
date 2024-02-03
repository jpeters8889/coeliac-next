<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import { ShopProductDetail, ShopProductReview } from '@/types/Shop';
import { PaginatedResponse } from '@/types/GenericTypes';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
import { ArrowUturnLeftIcon } from '@heroicons/vue/20/solid';
import StarRating from '@/Components/StarRating.vue';
import { nextTick, Ref, ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Modal from '@/Components/Overlays/Modal.vue';
import { MinusIcon, PlusIcon } from '@heroicons/vue/24/outline';
import ProductReviews from '@/Components/PageSpecific/Shop/ProductReviews.vue';
import ProductAddBasketForm from '@/Components/PageSpecific/Shop/ProductAddBasketForm.vue';
import useAddToBasket from '@/composables/useAddToBasket';

const props = defineProps<{
  product: ShopProductDetail;
  reviews: PaginatedResponse<ShopProductReview>;
  productShippingText: string;
}>();

const viewImage = ref(false);

const additionalDetails = ref([
  {
    title: 'Full Description',
    content: props.product.long_description,
    openByDefault: true,
  },
  {
    title: 'Postage Information',
    content: props.productShippingText,
    openByDefault: false,
  },
]);

const showReviews = ref(false);

const scrollToReviews = (): void => {
  showReviews.value = true;

  nextTick(() => {
    document.getElementById('reviews-dropdown')?.scrollIntoView();
  });
};

const allReviews: Ref<PaginatedResponse<ShopProductReview>> = ref(
  props.reviews
);

const loadMoreReviews = () => {
  if (!props.reviews.links.next) {
    return;
  }

  router.get(
    props.reviews.links.next,
    {},
    {
      preserveScroll: true,
      preserveState: true,
      only: ['reviews'],
      replace: true,
      onSuccess: (event: {
        props: { reviews?: PaginatedResponse<ShopProductReview> };
      }) => {
        // eslint-disable-next-line no-restricted-globals
        history.replaceState(
          null,
          '',
          `${window.location.origin}${window.location.pathname}`
        );

        if (!event.props.reviews) {
          return true;
        }

        allReviews.value.data.push(...event.props.reviews.data);
        allReviews.value.links = event.props.reviews.links;
        allReviews.value.meta = event.props.reviews.meta;

        return false;
      },
    }
  );
};
</script>

<template>
  <Card class="m-3 flex flex-col space-y-4 p-0">
    <div class="mx-auto">
      <!-- Product details -->
      <div class="space-y-3 md:self-end lg:space-y-4">
        <nav>
          <ol
            role="list"
            class="flex items-center space-x-2"
          >
            <li>
              <div class="flex items-center text-sm">
                <Link
                  :href="product.category.link"
                  class="inline-flex items-center font-medium text-gray-500 hover:text-primary-dark xl:text-lg"
                >
                  <ArrowUturnLeftIcon class="h-6 w-6 pr-2 xl:h-8 xl:w-8" />
                  <span class="leading-none">
                    Back to <strong v-text="product.category.title" />
                  </span>
                </Link>
              </div>
            </li>
          </ol>
        </nav>

        <div>
          <h1
            class="text-2xl font-semibold tracking-tight lg:text-4xl"
            v-text="product.title"
          />
        </div>

        <div
          class="space-y-3 md:grid md:grid-cols-2 md:gap-3 lg:grid-cols-3 lg:gap-5 2xl:gap-7"
        >
          <!-- Product image -->
          <div
            class="cursor-zoom-in md:col-start-1"
            @click="viewImage = true"
          >
            <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg">
              <img
                :src="product.image"
                :alt="product.title"
                class="h-full w-full object-cover object-center"
              />
            </div>
          </div>

          <section class="flex flex-col space-y-5 lg:col-span-2">
            <div class="flex items-center md:items-start">
              <div class="flex flex-col">
                <p v-if="product.prices.old_price">
                  was
                  <span
                    class="font-semibold text-red line-through"
                    v-text="product.prices.old_price"
                  />
                  now
                </p>
                <p
                  class="text-3xl font-semibold leading-none xs:text-4xl"
                  v-text="product.prices.current_price"
                />
              </div>

              <div
                v-if="product.rating"
                class="group flex-1 cursor-pointer"
                @click="scrollToReviews()"
              >
                <div class="flex flex-col items-end justify-end">
                  <StarRating
                    size="w-4 h-4 xs:w-5 xs:h-5 xl:w-6 xl:h-6"
                    :rating="product.rating.average"
                  />

                  <p
                    class="text-sm text-gray-500 group-hover:text-primary-dark xs:text-base xl:text-lg"
                  >
                    {{ product.rating.count }} reviews
                  </p>
                </div>
              </div>
            </div>

            <div class="flex-1 space-y-6">
              <p
                class="prose max-w-none xs:prose-lg xl:prose-xl"
                v-text="product.description"
              />
            </div>

            <!-- Product form -->
            <ProductAddBasketForm :product="product" />
          </section>
        </div>
      </div>
    </div>
  </Card>

  <Card class="mx-3 !mt-0 mb-3 sm:p-4 lg:!mt-1">
    <div class="divide-y divide-gray-200">
      <Disclosure
        v-for="additionalDetail in additionalDetails"
        :key="additionalDetail.title"
        v-slot="{ open }"
        as="div"
        :default-open="additionalDetail.openByDefault"
      >
        <h3>
          <DisclosureButton
            class="group relative flex w-full items-center justify-between py-2 text-left"
          >
            <span
              class="text-lg font-semibold xl:text-xl"
              :class="open ? 'text-primary-dark' : ''"
              v-text="additionalDetail.title"
            />
            <span class="ml-6 flex items-center">
              <PlusIcon
                v-if="!open"
                class="block h-6 w-6 text-gray-400 group-hover:text-gray-500"
                aria-hidden="true"
              />
              <MinusIcon
                v-else
                class="block h-6 w-6 text-indigo-400 group-hover:text-indigo-500"
                aria-hidden="true"
              />
            </span>
          </DisclosureButton>
        </h3>

        <DisclosurePanel
          :id="additionalDetail.title"
          as="div"
          class="pb-6"
        >
          <div
            class="prose prose-lg max-w-none lg:prose-xl"
            v-html="additionalDetail.content"
          />
        </DisclosurePanel>
      </Disclosure>

      <Disclosure
        v-if="product.rating"
        as="div"
      >
        <h3>
          <DisclosureButton
            class="group relative flex w-full items-center justify-between py-2 text-left"
            @click="showReviews = !showReviews"
          >
            <span
              class="text-lg font-semibold xl:text-xl"
              :class="showReviews ? 'text-primary-dark' : ''"
              v-text="'Reviews'"
            />
            <span class="ml-6 flex items-center">
              <PlusIcon
                v-if="!showReviews"
                class="block h-6 w-6 text-gray-400 group-hover:text-gray-500"
                aria-hidden="true"
              />
              <MinusIcon
                v-else
                class="block h-6 w-6 text-indigo-400 group-hover:text-indigo-500"
                aria-hidden="true"
              />
            </span>
          </DisclosureButton>
        </h3>

        <DisclosurePanel
          v-show="showReviews"
          id="reviews-dropdown"
          as="div"
          class="pb-6"
          static
        >
          <ProductReviews
            :product-name="product.title"
            :reviews="allReviews"
            :rating="product.rating"
            @load-more="loadMoreReviews()"
          />
        </DisclosurePanel>
      </Disclosure>
    </div>
  </Card>

  <Modal
    :open="viewImage"
    size="full"
    no-padding
    @close="viewImage = false"
  >
    <img
      :src="product.image"
      :alt="product.title"
    />

    <template #footer>
      <span
        class="text-xs"
        v-text="product.title"
      />
    </template>
  </Modal>
</template>
