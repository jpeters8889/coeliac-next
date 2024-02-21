import { useForm } from 'laravel-precognition-vue-inertia';
import eventBus from '@/eventBus';
import { VisitOptions } from '@inertiajs/core';

type AddBasketPayload = {
  product_id: number;
  variant_id: number;
  quantity: number;
};

export default () => {
  const addBasketForm = useForm<Partial<AddBasketPayload>>(
    'put',
    '/shop/basket',
    {
      product_id: undefined,
      variant_id: undefined,
      quantity: 1,
    }
  );

  const prepareAddBasketForm = (
    productId: number,
    variantId: number,
    quantity: number = 1
  ) => {
    addBasketForm.product_id = productId;
    addBasketForm.variant_id = variantId;
    addBasketForm.quantity = quantity;
  };

  const submitAddBasketForm = (
    params: Partial<VisitOptions> = {},
    callback: Function | undefined = undefined
  ) => {
    addBasketForm.submit({
      ...params,
      preserveScroll: true,
      onSuccess: () => {
        eventBus.$emit('product-added-to-basket');

        if (callback) {
          callback();
        }
      },
    });
  };

  return { addBasketForm, prepareAddBasketForm, submitAddBasketForm };
};
