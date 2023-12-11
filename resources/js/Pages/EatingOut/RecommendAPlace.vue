<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import Heading from '@/Components/Heading.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import FormInput from '@/Components/Forms/FormInput.vue';
import FormTextarea from '@/Components/Forms/FormTextarea.vue';
import { FormSelectOption } from '@/Components/Forms/Props';
import FormSelect from '@/Components/Forms/FormSelect.vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import { CheckCircleIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

defineProps<{
  venueTypes: FormSelectOption[];
}>();

const form = useForm<{
  name: string;
  email: string;
  place: {
    name: string;
    location: string;
    url?: string;
    venueType?: number;
    details: string;
  };
}>('post', '/wheretoeat/recommend-a-place', {
  name: '',
  email: '',
  place: {
    name: '',
    location: '',
    url: '',
    venueType: undefined,
    details: '',
  },
});

const hasSubmitted = ref(false);

const submit = () => {
  form.submit({
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      hasSubmitted.value = true;
    },
  });
};
</script>

<template>
  <Card class="mt-3 flex flex-col space-y-4">
    <Heading>Recommend A Place</Heading>

    <template v-if="!hasSubmitted">
      <p class="prose max-w-none md:prose-lg">
        Do you know a place that needs adding to our guide? Well give us as much
        details as possible below and we'll check it out, verify it and get it
        added to our list!
      </p>

      <p class="prose max-w-none md:prose-lg">
        We rely on people like you providing us with information on places where
        people can eat out safely and helping us create a great eating out
        guide!
      </p>

      <p class="prose max-w-none md:prose-lg">
        Our eating out guide is full of independent eateries around the UK and
        Ireland, and we list
        <Link href="/wheretoeat/nationwide">nationwide chains</Link>, such as
        Nando's, Bella Italia separately.
      </p>

      <p class="prose max-w-none md:prose-lg">
        Don't forget to check out our
        <Link href="/eating-out">eating guide</Link> first to see if the place
        you're recommending already listed.
      </p>

      <form
        class="flex flex-col space-y-4"
        @submit.prevent="submit()"
      >
        <FormInput
          id="name"
          v-model="form.name"
          :error="form.errors.name"
          autocomplete="fullname"
          label="Your Name"
          name="name"
          required
          borders
        />

        <FormInput
          id="email"
          v-model="form.email"
          type="email"
          :error="form.errors.email"
          autocomplete="email"
          label="Your Email"
          name="email"
          required
          borders
        />

        <hr />

        <FormInput
          id="placeName"
          v-model="form.place.name"
          :error="form.errors['place.name']"
          label="Place Name"
          name="placeName"
          required
          borders
        />

        <FormTextarea
          v-model="form.place.location"
          label="Place Location / Address"
          required
          name="placeLocation"
          :rows="5"
          :error="form.errors['place.location']"
        />

        <FormInput
          id="placeWebAddress"
          v-model="form.place.url"
          type="url"
          :error="form.errors['place.url']"
          label="Place Website"
          name="placeUrl"
          borders
        />

        <FormSelect
          id="placeVenueType"
          v-model="form.place.venueType"
          name="placeVenueType"
          :options="venueTypes"
          label="Venue Type"
        />

        <FormTextarea
          v-model="form.place.details"
          label="Details"
          required
          name="placeDetails"
          :rows="8"
          :error="form.errors['place.details']"
        />

        <CoeliacButton
          theme="primary"
          size="lg"
          as="button"
          label="Send Recommendation"
          bold
          type="submit"
          classes="justify-center"
          :loading="form.processing"
        />
      </form>
    </template>

    <div
      v-else
      class="py-8"
    >
      <div class="mb-8 flex justify-center text-green">
        <CheckCircleIcon class="h-24 w-24" />
      </div>

      <p class="prose prose-lg max-w-none text-center">
        Thank you for submitting your recommendation! It has been added to my
        queue of places to check, I'll take a look at it, check menu's and
        reviews, and if it all checks out, add some missing data and add it to
        the website!
      </p>
    </div>
  </Card>
</template>
