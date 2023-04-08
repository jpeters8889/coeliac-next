import { HomeHoverItem } from '@/types/Types';

export type RecipeDetailCard = HomeHoverItem & {
  square_image: string;
  description: string;
  date: string;
  features?: { feature: string }[],
  nutrition: {
    servings: string,
    calories: number,
    portion_size: number,
  }
};

export type RecipeFeature = {
  feature: string;
  slug: string;
  recipes_count: number;
};

export type RecipeMeal = {
  meal: string;
  slug: string;
  recipes_count: number;
};

export type RecipeFreeFrom = {
  allergen: string;
  slug: string;
  recipes_count: number;
};
