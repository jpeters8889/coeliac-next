<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import { CheckoutForm, ShopBasketItem } from '@/types/Shop';
import Heading from '@/Components/Heading.vue';
import CheckoutItems from '@/Components/PageSpecific/Shop/Checkout/CheckoutItems.vue';
import CheckoutTotals from '@/Components/PageSpecific/Shop/Checkout/CheckoutTotals.vue';
import { FormSelectOption } from '@/Components/Forms/Props';
import ContactDetails from '@/Components/PageSpecific/Shop/Checkout/Form/ContactDetails.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { Ref, ref } from 'vue';
import ShippingDetails from '@/Components/PageSpecific/Shop/Checkout/Form/ShippingDetails.vue';
import useShopStore from '@/stores/useShopStore';
import useLocalStorage from '@/composables/useLocalStorage';

type NoBasketProps = {
  has_basket: false;
  countries: undefined;
  basket: undefined;
};

type BasketProps = {
  has_basket: true;
  countries: FormSelectOption[];
  basket: {
    items: ShopBasketItem[];
    selected_country: number;
    delivery_timescale: string;
    subtotal: string;
    postage: string;
    total: string;
  };
};

defineProps<NoBasketProps | BasketProps>();
const store = useShopStore();

const { getFromLocalStorage, putInLocalStorage } = useLocalStorage();

const form = useForm<CheckoutForm>(
  'post',
  '/shop/basket',
  getFromLocalStorage<CheckoutForm>('checkout-form', store.toForm)
);

if (getFromLocalStorage('checkout-form')) {
  store.setForm(getFromLocalStorage('checkout-form'));
}

type SectionKeys = 'details' | 'shipping' | 'billing' | 'payment';
type FormSection = {
  [T in SectionKeys]: {
    active: boolean;
    complete: boolean;
    error: boolean;
  };
};

const sections: Ref<FormSection> = ref(
  getFromLocalStorage<FormSection>('checkout-steps', {
    details: {
      active: true,
      complete: false,
      error: false,
    },
    shipping: {
      active: false,
      complete: false,
      error: false,
    },
    billing: {
      active: false,
      complete: false,
      error: false,
    },
    payment: {
      active: false,
      complete: false,
      error: false,
    },
  })
);

const completeSection = (section: SectionKeys, next: SectionKeys) => {
  putInLocalStorage('checkout-form', store.toForm);
  form.defaults(store.toForm);
  form.reset();

  sections.value = {
    ...sections.value,
    [section]: {
      active: false,
      complete: true,
      error: false,
    },
    [next]: {
      active: true,
      complete: false,
      error: false,
    },
  };

  putInLocalStorage('checkout-steps', sections.value);
};
</script>

<template>
  <Card class="mt-3 flex flex-col space-y-4">
    <Heading
      :back-link="{ href: '/shop', label: 'Continue shopping...' }"
      :border="false"
    >
      Complete your order
    </Heading>
  </Card>

  <template v-if="has_basket && basket">
    <div class="grid grid-cols-1 gap-x-4 gap-y-4 lg:grid-cols-2 xl:grid-cols-3">
      <Card
        theme="primary-light"
        class="bg-opacity-20"
      >
        <CheckoutItems :items="basket.items" />
        <CheckoutTotals
          :countries="countries"
          :selected-country="basket.selected_country"
          :delivery-timescale="basket.delivery_timescale"
          :postage="basket.postage"
          :total="basket.total"
          :subtotal="basket.subtotal"
        />
      </Card>

      <Card class="xl:col-span-2">
        <form class="flex flex-col gap-5 divide-y divide-grey-off-light">
          <ContactDetails
            :show="sections.details.active"
            :completed="sections.details.complete"
            @continue="completeSection('details', 'shipping')"
          />

          <ShippingDetails
            :show="sections.shipping.active"
            :completed="sections.shipping.complete"
            :can-lookup-postcode="basket.selected_country === 1"
            @continue="completeSection('shipping', 'billing')"
          />
        </form>
      </Card>
    </div>
  </template>
</template>
