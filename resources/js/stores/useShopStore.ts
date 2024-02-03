import { defineStore } from 'pinia';
import {
  CheckoutContactStep,
  CheckoutForm,
  CheckoutShippingStep,
} from '@/types/Shop';

type Keys = keyof CheckoutForm;

type State = {
  data: CheckoutForm;
  country: string;
  errors: Partial<CheckoutForm>;
};

type Getters = {
  toForm: (state: State) => CheckoutForm;
  getErrors: (state: State) => Partial<CheckoutForm>;
  customerName: (state: State) => string;
  userDetails: (state: State) => CheckoutContactStep;
  shippingDetails: (state: State) => CheckoutShippingStep;
  selectedCountry: (state: State) => string;
};

type Actions = {
  setForm: (state: Partial<CheckoutForm>) => void;
  setUserDetails: (state: CheckoutContactStep) => void;
  setShippingDetails: (state: CheckoutShippingStep) => void;
  setErrors: (state: Partial<CheckoutForm>) => void;
  setCountry: (country: string) => void;
};

const useShopStore = defineStore<'shop-checkout', State, Getters, Actions>(
  'shop-checkout',
  {
    state: () => ({
      data: {
        // user
        name: '',
        email: '',
        email_confirmation: '',
        phone: '',

        // shipping
        address_1: '',
        address_2: '',
        address_3: '',
        town: '',
        postcode: '',
      },

      country: '',

      errors: {},
    }),
    getters: {
      toForm: (state) => state.data,
      getErrors: (state) => state.errors,
      customerName: (state) => state.data.name,
      userDetails: (state): CheckoutContactStep => ({
        name: state.data.name,
        email: state.data.email,
        email_confirmation: state.data.email_confirmation,
        phone: state.data.phone,
      }),
      shippingDetails: (state): CheckoutShippingStep => ({
        address_1: state.data.address_1,
        address_2: state.data.address_2,
        address_3: state.data.address_3,
        town: state.data.town,
        postcode: state.data.postcode,
      }),
      selectedCountry: (state) => state.country,
    },
    actions: {
      setErrors(state) {
        this.errors = { ...state };
      },
      setForm(state) {
        Object.keys(state).forEach((key) => {
          this.data[<Keys>key] = <string>state[<Keys>key];
        });
      },
      setUserDetails(details) {
        this.setForm(details);
      },
      setShippingDetails(details) {
        this.setForm(details);
      },
      setCountry(country: string) {
        this.country = country;
      },
    },
  }
);

export default useShopStore;
