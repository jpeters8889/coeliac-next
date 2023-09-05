<script lang="ts" setup>
import { DetailedEatery } from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, ComputedRef, nextTick, Ref, ref } from 'vue';
import FormInput from '@/Components/Forms/FormInput.vue';
import FormTextarea from '@/Components/Forms/FormTextarea.vue';
import FormStepper from '@/Components/Forms/FormStepper.vue';
import { CurrencyPoundIcon, StarIcon } from '@heroicons/vue/24/solid';
import { FormSelectOption } from '@/Components/Forms/Props';
import FormCheckbox from '@/Components/Forms/FormCheckbox.vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import UploadReviewImages from '@/Components/PageSpecific/EatingOut/Details/Reviews/UploadReviewImages.vue';

const props = defineProps<{
  eatery: DetailedEatery;
}>();

let form = useForm<{
  rating: 0 | 1 | 2 | 3 | 4 | 5;
  name?: string;
  email?: string;
  body?: string;
  food?: string;
  service?: string;
  expense?: string;
  images?: Array<any>;
  branchName?: string;
  adminReview?: boolean;
}>({
  rating: 0,
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

const submitRating = (short: boolean = false) => {
  //
};

const isAdmin = (): boolean =>
  // @todo
  false;

const imageUploadError: Ref<string, false> = ref(false);

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

const prepareForm = (): void => {
  form = useForm({
    ...form.data(),
    name: '',
    email: '',
    body: '',
    food: '',
    service: '',
    expense: '',
    images: [],
    ...(isAdmin() ? { adminReview: false } : null),
    ...(props.eatery.county.id === 1
      ? {
          branchName: props.eatery?.branch?.name
            ? props.eatery.branch.name
            : '',
        }
      : null),
  });

  nextTick(() => {
    showForm.value = true;
  });
};
</script>

<template>
  <Card class="space-y-3">
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
        You're about to give a <strong>{{ form.rating }} star</strong> rating to
        <strong>{{ eatery.name }}</strong
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
          @click="submitRating(true)"
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
          />
        </div>
        <div class="flex-1">
          <FormInput
            v-model="form.email"
            required
            name="email"
            type="email"
            label="Your Email"
          />
        </div>
        <div class="flex-1">
          <FormStepper
            v-model="form.food"
            name="food"
            label="How would you rate your food?"
            :options="ratings"
          />
        </div>
        <div class="flex-1">
          <FormStepper
            v-model="form.service"
            name="service"
            label="How would you rate the service?"
            :options="ratings"
          />
        </div>
        <div class="flex-1">
          <FormStepper
            v-model="form.expense"
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
            v-model="form.branchName"
            required
            name="branchName"
            type="branchName"
            label="What branch did you eat at?"
          />
        </div>
        <div class="flex-1">
          <FormTextarea
            v-model="form.body"
            required
            name="comment"
            :rows="5"
            label="Your Comment"
            v-bind="isAdmin() ? {} : { max: 1500 }"
          />
          <span
            class="text-right text-xs"
            :class="
              characterLimit === usedCharacters ? 'font-semibold text-red' : ''
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
          All comments need to be approved before they are shown on the website,
          this usually takes no longer than 48 hours.
        </p>
      </div>

      <div v-if="hasSubmitted">
        <p>
          Thank you for leaving your
          <strong>{{ form.rating }} star</strong> rating
          {{ showForm ? 'and review' : '' }} of
          <strong>{{ eatery.name }}</strong
          >!
        </p>
      </div>
    </template>
  </Card>
</template>
