<script setup lang="ts">
import FormInput from '@/Components/Forms/FormInput.vue';
import { computed, reactive, ref, watch } from 'vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import { ArrowRightIcon, CheckIcon } from '@heroicons/vue/24/outline';
import useShopStore from '@/stores/useShopStore';
import AddressLookup from '@/Components/PageSpecific/Shop/Checkout/Form/Components/AddressLookup.vue';
import { CheckoutShippingStep } from '@/types/Shop';

defineProps<{
  show: boolean;
  completed: boolean;
  canLookupPostcode: boolean;
}>();

defineEmits(['continue']);

const store = useShopStore();

const data = reactive({ ...store.shippingDetails });
const { customerName } = store;
const errors = store.getErrors;

const disableButton = computed((): boolean => {
  if (data.address_1 === '') {
    return true;
  }

  if (data.town === '') {
    return true;
  }

  if (data.postcode === '') {
    return true;
  }

  return false;
});

const handleAddressLookup = (address: CheckoutShippingStep) => {
  data.address_1 = address.address_1;
  data.address_2 = address.address_2;
  data.address_3 = address.address_3;
  data.town = address.town;
  data.county = address.county;
  data.postcode = address.postcode;
};

const addressActive = ref(false);

watch(data, () => store.setShippingDetails(data));
</script>

<template>
  <div class="flex flex-col space-y-6 pt-4">
    <h2
      class="flex justify-between text-3xl font-semibold"
      :class="{
        'text-primary-dark': show || completed,
        'text-grey-off': !show,
      }"
    >
      <span>Shipping Details</span>
      <CheckIcon
        v-if="completed"
        class="h-8 w-8 text-green"
      />
    </h2>

    <template v-if="show">
      <p class="prose !mt-2 max-w-none xl:prose-lg">
        Thanks {{ customerName }}, next we need to know where to send your
        order.
      </p>

      <AddressLookup
        :address="data.address_1"
        :active="addressActive"
        @set-address="handleAddressLookup"
      >
        <FormInput
          v-model="data.address_1"
          :error="errors.address_1"
          label="Address (Line 1)"
          name="address_1"
          autocomplete="off"
          required
          borders
          @focus="addressActive = true"
          @blur="addressActive = false"
        />
      </AddressLookup>

      <FormInput
        v-model="data.address_2"
        :error="errors.address_2"
        label="Address (Line 2)"
        name="address_2"
        autocomplete="address_2"
        borders
      />

      <FormInput
        v-model="data.address_3"
        :error="errors.address_3"
        label="Address (Line 3)"
        name="address_3"
        autocomplete="address_3"
        borders
      />

      <FormInput
        v-model="data.town"
        :error="errors.town"
        label="Town / City"
        name="town"
        autocomplete="town"
        required
        borders
      />

      <FormInput
        v-model="data.county"
        :error="errors.county"
        label="County"
        name="county"
        autocomplete="county"
        borders
      />

      <FormInput
        v-model="data.postcode"
        :error="errors.postcode"
        label="Postcode"
        name="postcode"
        autocomplete="postcode"
        class="flex-1"
        required
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
