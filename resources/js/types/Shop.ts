import { StarRating } from '@/types/EateryTypes';

export type ShopCategoryIndex = {
  title: string;
  description: string;
  link: string;
  image: string;
};

export type ShopBaseProduct = {
  title: string;
  description: string;
  image: string;
  rating?: {
    average: StarRating;
    count: number;
  };
};

export type ShopProductIndex = ShopBaseProduct & {
  id: number;
  link: string;
  price: string;
  number_of_variants: number;
  primary_variant: number;
};

export type ShopProductDetail = ShopBaseProduct & {
  id: number;
  long_description: string;
  prices: {
    current_price: string;
    old_price?: string;
  };
  variant_title: string;
  variants: ShopProductVariant[];
  category: {
    title: string;
    link: string;
  };
  rating?: ShopProductRating;
};

export type ShopProductVariant = {
  id: number;
  title: string;
  icon?: {
    component: string;
    color: string;
  };
  quantity: number;
};

export type ShopProductRating = {
  average: StarRating;
  count: number;
  breakdown: {
    rating: StarRating;
    count: number;
  }[];
};

export type ShopProductReview = {
  name: string;
  review: string;
  rating: StarRating;
  date: string;
  date_diff: string;
};

export type ShopBasketItem = {
  id: number;
  title: string;
  link: string;
  variant: string;
  item_price: string;
  line_price: string;
  quantity: number;
  image: string;
};

export type CheckoutContactStep = {
  name: string;
  email: string;
  email_confirmation: string;
  phone?: string;
};

export type CheckoutShippingStep = {
  address_1: string;
  address_2?: string;
  address_3?: string;
  town: string;
  county: string;
  postcode: string;
};

export type CheckoutForm = CheckoutContactStep & CheckoutShippingStep;
