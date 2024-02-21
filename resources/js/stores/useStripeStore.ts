import { defineStore } from 'pinia';
import { Stripe } from '@stripe/stripe-js/types/stripe-js';
import { StripeElements } from '@stripe/stripe-js/types/stripe-js/elements-group';
import { loadStripe } from '@stripe/stripe-js';

type State = {
  instantiated: boolean;
  stateStripe: Stripe;
  stateElements: StripeElements;
};

type Getters = {
  stripe: (state: State) => Stripe;
  elements: (state: State) => StripeElements;
};

type Actions = {
  instantiate: (paymentIntentId: string) => Promise<void>;
};

const useStripeStore = defineStore<'stripe', State, Getters, Actions>(
  'stripe',
  {
    state: () => ({
      instantiated: false,
      stateStripe: {} as Stripe,
      stateElements: {} as StripeElements,
    }),
    getters: {
      stripe: (state) => state.stateStripe,
      elements: (state) => state.stateElements,
    },
    actions: {
      async instantiate(clientSecret: string) {
        if (this.instantiated) {
          return;
        }

        // @ts-ignore
        const key: string = import.meta.env.VITE_STRIPE_PUBLIC_KEY;

        this.stateStripe = (await loadStripe(key)) as Stripe;
        this.stateElements = this.stateStripe.elements({
          clientSecret,
          appearance: {
            variables: {
              colorPrimary: '#80CCFC',
            },
          },
        });

        this.instantiated = true;
      },
    },
  }
);

export default useStripeStore;
