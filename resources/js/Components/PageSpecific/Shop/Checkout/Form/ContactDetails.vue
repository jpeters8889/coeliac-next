<script setup lang="ts">
import FormInput from '@/Components/Forms/FormInput.vue';
import { computed, reactive, ref, watch } from 'vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import { ArrowRightIcon, CheckIcon } from '@heroicons/vue/24/outline';
import useShopStore from '@/stores/useShopStore';

defineProps<{ show: boolean; completed: boolean }>();
defineEmits(['continue']);

const store = useShopStore();

const data = reactive({ ...store.userDetails });
const errors = store.getErrors;

const disableButton = computed((): boolean => {
  if (!data) {
    return true;
  }

  if (data.name === '') {
    return true;
  }

  if (data.email === '') {
    return true;
  }

  if (data.email !== data.email_confirmation) {
    return true;
  }

  return false;
});

watch(data, () => store.setUserDetails(data));
</script>

<template>
  <div class="flex flex-col space-y-6">
    <h2
      class="flex items-center justify-between text-3xl font-semibold"
      :class="{
        'text-primary-dark': show || completed,
        'text-grey-off': !show,
      }"
    >
      <span>Your Details</span>
      <CheckIcon
        v-if="completed"
        class="h-8 w-8 text-green"
      />
    </h2>

    <template v-if="show">
      <p class="prose !mt-2 max-w-none xl:prose-lg">
        To start the checkout process we just need some basic details from you
        including your name, the email address for your order confirmation, and
        optionally, a telephone number.
      </p>

      <FormInput
        v-model="data.name"
        :error="errors.name"
        label="Your name"
        name="name"
        autocomplete="name"
        required
        borders
      />

      <FormInput
        v-model="data.email"
        :error="errors.email"
        type="email"
        label="Your Email"
        name="email"
        autocomplete="email"
        required
        borders
      />

      <FormInput
        v-model="data.email_confirmation"
        :error="errors.email_confirmation"
        type="email"
        label="Confirm Email"
        name="email_confirmation"
        autocomplete="email"
        required
        borders
      />

      <FormInput
        v-model="data.phone"
        :error="errors.phone"
        label="Your Phone Number"
        name="phone"
        autocomplete="phone"
        type="phone"
        borders
      />

      <CoeliacButton
        as="button"
        type="button"
        label="Continue..."
        size="xxl"
        classes="!px-6 text-xl justify-between"
        theme="secondary"
        :icon="ArrowRightIcon"
        icon-position="right"
        :disabled="disableButton"
        @click="$emit('continue')"
      />
    </template>
  </div>
</template>
