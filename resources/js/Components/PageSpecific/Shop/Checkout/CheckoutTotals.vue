<script setup lang="ts">
import { FormSelectOption } from '@/Components/Forms/Props';
import FormSelect from '@/Components/Forms/FormSelect.vue';
import { computed, ref, watch } from 'vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import Loader from '@/Components/Loader.vue';
import useShopStore from '@/stores/useShopStore';

const props = defineProps<{
  countries: FormSelectOption[];
  selectedCountry: number;
  deliveryTimescale: string;
  subtotal: string;
  postage: string;
  total: string;
}>();

const store = useShopStore();

const deliveryEstimate = computed(() => {
  const method =
    props.selectedCountry === 1 ? 'First Class' : 'International Standard';

  return `Delivered by Royal Mail ${method} usually within ${props.deliveryTimescale} days.`;
});

const countryForm = useForm('patch', '/shop/basket', {
  postage_country_id: props.selectedCountry,
});

const updateStore = () => {
  const selectedOption: FormSelectOption | undefined = props.countries.find(
    (country) => country.value === countryForm.postage_country_id
  );

  if (!selectedOption) {
    return;
  }

  store.setCountry(<string>selectedOption.label);
};

updateStore();

const isLoading = ref(false);

watch(
  () => countryForm.postage_country_id,
  () => {
    isLoading.value = true;

    countryForm.submit({
      preserveScroll: true,
      onSuccess: () => {
        isLoading.value = false;
        updateStore();
      },
    });
  }
);
</script>

<template>
  <div class="w-full">
    <dl class="mt-10 space-y-3">
      <div class="flex justify-between">
        <dt class="lg:text-lg xl:text-xl">Subtotal</dt>
        <dd
          class="text-lg font-semibold lg:text-xl xl:text-2xl"
          v-text="subtotal"
        />
      </div>
      <div class="relative flex justify-between">
        <Loader
          :display="isLoading"
          absolute
          on-top
          blur
          color="secondary"
          size="w-12 h-12"
          width="border-8"
        />

        <dt class="flex-1 pr-2 xs:pr-4">
          <div
            class="flex flex-col sm:w-full sm:flex-row sm:items-center sm:space-x-3 lg:text-lg xl:text-xl"
          >
            <span>Postage to</span>
            <FormSelect
              v-model="countryForm.postage_country_id"
              class="sm:flex-1"
              name="country"
              :options="countries"
            />
          </div>
          <small
            class="mt-2 block leading-tight xl:text-base"
            v-text="deliveryEstimate"
          />
          <small
            v-if="selectedCountry > 1"
            class="mt-2 block font-semibold xl:text-base"
          >
            Please note, you may be required to pay any applicable customs
            charges for any items coming from the UK.
          </small>
        </dt>
        <dd
          class="flex-shrink-0 text-lg font-semibold lg:text-xl xl:text-2xl"
          v-text="postage"
        />
      </div>
      <div
        class="flex justify-between border-t border-t border-gray-200 border-secondary pt-3 text-xl font-semibold lg:text-2xl xl:text-3xl"
      >
        <dt class="">Total</dt>
        <dd
          class="font-semibold"
          v-text="total"
        />
      </div>
    </dl>
  </div>
</template>
