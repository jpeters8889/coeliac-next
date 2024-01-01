<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import { ShopProductDetail, ShopProductReview } from '@/types/Shop';
import { PaginatedResponse } from '@/types/GenericTypes';
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  RadioGroup,
  RadioGroupDescription,
  RadioGroupLabel,
  RadioGroupOption,
} from '@headlessui/vue';
import { ArrowUturnLeftIcon } from '@heroicons/vue/20/solid';
import StarRating from '@/Components/StarRating.vue';
import { nextTick, Ref, ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import Modal from '@/Components/Overlays/Modal.vue';
import FormInput from '@/Components/Forms/FormInput.vue';
import { MinusIcon, PlusIcon } from '@heroicons/vue/24/outline';
import ProductReviews from '@/Components/PageSpecific/Shop/ProductReviews.vue';

const props = defineProps<{
  product: ShopProductDetail;
  reviews: PaginatedResponse<ShopProductReview>;
  productShippingText: string;
}>();

const selectedVariant = ref();
const quantity = ref(1);
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
      onSuccess: (event: {
        props: { reviews?: PaginatedResponse<ShopProductReview> };
      }) => {
        // eslint-disable-next-line no-restricted-globals
        history.pushState(
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
    <div class="mx-auto p-3 sm:p-4">
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
              <p
                class="text-3xl font-semibold leading-none xs:text-4xl"
                v-text="product.prices.current_price"
              />

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
            <div
              class="mt-3 w-full md:col-start-1 md:row-start-2 md:max-w-lg md:self-start"
            >
              <form class="flex w-full flex-col space-y-3">
                <div
                  v-if="product.variants.length > 1"
                  class="sm:flex sm:justify-between"
                >
                  <RadioGroup v-model="selectedVariant">
                    <div class="mt-1 grid grid-cols-1 gap-4 sm:grid-cols-2">
                      <RadioGroupOption
                        v-for="variant in product.variants"
                        :key="variant.id"
                        v-slot="{ active, checked }"
                        as="template"
                        :value="variant"
                      >
                        <div
                          :class="[
                            active ? 'ring-2 ring-indigo-500' : '',
                            'relative block cursor-pointer rounded-lg border border-gray-300 p-4 focus:outline-none',
                          ]"
                        >
                          <RadioGroupLabel
                            as="p"
                            class="text-base font-medium text-gray-900"
                            >{{ variant.title }}</RadioGroupLabel
                          >
                          <RadioGroupDescription
                            v-if="false"
                            as="p"
                            class="mt-1 text-sm text-gray-500"
                            >{{ variant.title }}</RadioGroupDescription
                          >
                          <div
                            :class="[
                              active ? 'border' : 'border-2',
                              checked
                                ? 'border-indigo-500'
                                : 'border-transparent',
                              'pointer-events-none absolute -inset-px rounded-lg',
                            ]"
                            aria-hidden="true"
                          />
                        </div>
                      </RadioGroupOption>
                    </div>
                  </RadioGroup>
                </div>

                <div class="w-full *:w-full sm:flex sm:justify-between">
                  <FormInput
                    v-model.number="quantity"
                    type="number"
                    label="Quantity"
                    name="quantity"
                    size="large"
                    :min="1"
                    borders
                  />
                </div>

                <div class="flex items-center justify-between">
                  <CoeliacButton
                    as="button"
                    size="xxl"
                    label="Add To Basket"
                  />
                </div>
              </form>
            </div>
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
