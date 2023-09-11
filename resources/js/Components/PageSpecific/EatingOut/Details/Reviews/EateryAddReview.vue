<script lang="ts" setup>
import { DetailedEatery } from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { computed, ComputedRef, nextTick, Ref, ref } from 'vue';
import FormInput from '@/Components/Forms/FormInput.vue';
import FormTextarea from '@/Components/Forms/FormTextarea.vue';
import FormStepper from '@/Components/Forms/FormStepper.vue';
import { CurrencyPoundIcon, StarIcon } from '@heroicons/vue/24/solid';
import { CheckCircleIcon } from '@heroicons/vue/24/outline';
import { FormSelectOption } from '@/Components/Forms/Props';
import FormCheckbox from '@/Components/Forms/FormCheckbox.vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import UploadReviewImages from '@/Components/PageSpecific/EatingOut/Details/Reviews/UploadReviewImages.vue';
import useUrl from '@/composables/useUrl';

const props = defineProps<{
  eatery: DetailedEatery;
}>();

const { generateUrl } = useUrl();

type RatingFormPayload = {
  rating: 0 | 1 | 2 | 3 | 4 | 5;
  method: 'website';
};

type ReviewFormPayload = RatingFormPayload & {
  name: string;
  email: string;
  review: string;
  food_rating: string;
  service_rating: string;
  how_expensive: string;
  images: string[];
  branch_name: string;
  admin_review: boolean;
};

let form = useForm<RatingFormPayload>('post', generateUrl('reviews'), {
  rating: 0,
  method: 'website',
});

const characterLimit = 1500;

const showForm = ref(false);
const hasSubmitted = ref(false);

const stars = computed((): FormSelectOption[] => [
  { value: 1 },
  { value: 2 },
  { value: 3 },
  { value: 4 },
  { value: 5 },
]);

const ratings = computed((): FormSelectOption[] => [
  { value: 'poor', label: 'Poor' },
  { value: 'good', label: 'Good' },
  { value: 'excellent', label: 'Excellent' },
]);

const howExpensiveValues = computed((): FormSelectOption[] => [
  { value: 1, label: 'Cheap and quick' },
  { value: 2, label: 'Great Value' },
  { value: 3, label: 'Average' },
  { value: 4, label: 'A special treat' },
  { value: 5, label: 'Expensive' },
]);

const usedCharacters: ComputedRef<number> = computed(
  () => form.body?.length || 0
);

const submitRating = () => {
  form.submit({
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => {
      hasSubmitted.value = true;
    },
  });
};

const isAdmin = (): boolean =>
  // @todo
  false;

const imageUploadError: Ref<string | false> = ref(false);

const imagesUploaded = (images: any[]): void => {
  imageUploadError.value = false;

  if (!form.images) {
    return;
  }

  form.images = images;
};

const imageError = (message: string): void => {
  imageUploadError.value = message;
};

const branchName = (): string => {
  if (props.eatery.branch?.name) {
    return props.eatery.branch.name;
  }

  return '';
};

const prepareForm = (): void => {
  form = useForm<ReviewFormPayload>('post', generateUrl('reviews'), {
    ...form.data(),
    name: '',
    email: '',
    review: '',
    food_rating: '',
    service_rating: '',
    how_expensive: '',
    images: [],
    ...(isAdmin() ? { adminReview: false } : null),
    ...(props.eatery.county.id === 1 ? { branchName: branchName() } : null),
  });

  nextTick(() => {
    showForm.value = true;
  });
};

const submittedText = computed((): string => {
  let text = `Thank you for leaving your
    <strong>${form.rating} star</strong> rating
    ${showForm.value ? 'and review' : ''} of
    <strong>${props.eatery.name}</strong>!`;

  if (showForm.value) {
    text += 'Your review will be checked by an admin before it goes live.';
  }

  return text;
});
</script>

<template>
  <Card class="space-y-3">
    <div
      v-if="hasSubmitted"
      class="py-8"
    >
      <div class="mb-8 flex justify-center text-green">
        <CheckCircleIcon class="h-24 w-24" />
      </div>

      <p
        class="text-center text-xl"
        v-html="submittedText"
      />
    </div>

    <template v-else>
      <p>
        Have you visited <strong>{{ eatery.name }}</strong
        >? How would you rate your experience from 1 to 5 stars?
      </p>

      <FormStepper
        v-model="form.rating"
        name="rating"
        :options="stars"
        :icon="StarIcon"
        :unselected-icon="null"
        :icon-classes="['w12 h-12']"
        hide-options-text
      />

      <template v-if="form.rating">
        <p>
          You're about to give a <strong>{{ form.rating }} star</strong> rating
          to <strong>{{ eatery.name }}</strong
          >.
        </p>

        <p v-if="!showForm">
          Do you want to also write a short review about your experience at
          <strong>{{ eatery.name }}</strong
          >, or just submit your <strong>{{ form.rating }} star</strong> rating?
        </p>

        <div
          v-if="!showForm"
          class="flex flex-col space-y-2 sm:flex-row sm:justify-between sm:space-y-0 lg:justify-start lg:space-x-3"
        >
          <CoeliacButton
            theme="primary"
            size="lg"
            as="button"
            label="No, just save my rating"
            bold
            type="button"
            classes="justify-center"
            :loading="form.processing"
            @click="submitRating()"
          />

          <CoeliacButton
            theme="secondary"
            size="lg"
            as="button"
            label="Yes, I want to leave a review"
            bold
            type="button"
            classes="justify-center"
            @click="prepareForm()"
          />
        </div>

        <div
          v-if="showForm"
          class="flex flex-col space-y-4"
        >
          <div class="flex-1">
            <FormInput
              v-model="form.name"
              required
              name="name"
              label="Your Name"
              :error="form.errors.name"
            />
          </div>
          <div class="flex-1">
            <FormInput
              v-model="form.email"
              required
              name="email"
              type="email"
              label="Your Email"
              :error="form.errors.email"
            />
          </div>
          <div class="flex-1">
            <FormStepper
              v-model="form.food_rating"
              name="food"
              label="How would you rate your food?"
              :options="ratings"
            />
          </div>
          <div class="flex-1">
            <FormStepper
              v-model="form.service_rating"
              name="service"
              label="How would you rate the service?"
              :options="ratings"
            />
          </div>
          <div class="flex-1">
            <FormStepper
              v-model="form.how_expensive"
              name="expense"
              label="How expensive is it to eat here?"
              :options="howExpensiveValues"
              :icon="CurrencyPoundIcon"
              :unselected-icon="null"
            />
          </div>
          <div
            v-if="eatery.county.id === 1 && !eatery.branch"
            class="flex-1"
          >
            <FormInput
              v-model="form.branch_name"
              required
              name="branchName"
              type="branchName"
              label="What branch did you eat at?"
              :error="form.error.branch_name"
            />
          </div>
          <div class="flex-1">
            <FormTextarea
              v-model="form.review"
              required
              name="comment"
              :rows="5"
              label="Your Comment"
              v-bind="isAdmin() ? {} : { max: 1500 }"
              :error="form.errors.review"
            />
            <span
              class="text-right text-xs"
              :class="
                characterLimit === usedCharacters
                  ? 'font-semibold text-red'
                  : ''
              "
            >
              {{ usedCharacters }} / {{ characterLimit }}
            </span>
          </div>

          <div
            v-if="isAdmin()"
            class="flex-1"
          >
            <FormCheckbox
              v-model="form.adminReview"
              name="admin_review"
              label="Post as admin review"
            />
          </div>

          <div>
            <UploadReviewImages
              @images-change="imagesUploaded"
              @error="imageError"
            />

            <div
              v-if="imageUploadError"
              class="font-semibold text-red"
              v-text="imageUploadError"
            />
          </div>

          <div class="flex-1 text-center">
            <CoeliacButton
              theme="primary"
              size="lg"
              as="button"
              label="Submit Review"
              bold
              type="submit"
              :loading="form.processing"
              @click="submitRating()"
            />
          </div>

          <p class="text-sm">
            We require your email in case we need to contact you about your
            comment, your email address is NEVER displayed publicly with your
            comment.
          </p>

          <p class="text-sm">
            All comments need to be approved before they are shown on the
            website, this usually takes no longer than 48 hours.
          </p>
        </div>
      </template>
    </template>
  </Card>
</template>
