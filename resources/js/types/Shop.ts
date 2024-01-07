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
