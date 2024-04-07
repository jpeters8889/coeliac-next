<script setup lang="ts">
import eventBus from '@/eventBus';
import { StripePaymentElementChangeEvent } from '@stripe/stripe-js/types/stripe-js/elements/payment';
import useStripeStore from '@/stores/useStripeStore';
import { computed, watch, watchEffect } from 'vue';

const props = defineProps<{ paymentToken: string }>();

const emits = defineEmits(['payment-ready', 'payment-not-valid']);

const stripeStore = useStripeStore();

stripeStore.instantiate(props.paymentToken).then(() => {
  const paymentElement = stripeStore.elements.create('payment', {
    layout: {
      type: 'accordion',
      defaultCollapsed: false,
      radios: false,
      spacedAccordionItems: true,
    },
    fields: {
      billingDetails: 'never',
    },
  });

  paymentElement.mount('#stripe');

  eventBus.$on('refresh-payment-element', () => {
    console.log({
      token: props.paymentToken,
      note: 'Refreshing',
    });
    stripeStore.elements.fetchUpdates();
  });

  paymentElement.on('change', (event: StripePaymentElementChangeEvent) => {
    if (event.complete) {
      emits('payment-ready');
      return;
    }

    emits('payment-not-valid');
  });

  paymentElement.on('ready', () => {
    eventBus.$emit('payment-widget-loaded');
  });
});
</script>

<template>
  <div>
    <div id="stripe" />
  </div>
</template>
