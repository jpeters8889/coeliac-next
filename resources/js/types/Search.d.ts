import { LatLng } from '@/types/EateryTypes';

export type SearchParams = {
  q: string;
  blogs: boolean;
  recipes: boolean;
  eateries: boolean;
  shop: boolean;
};

export type SearchableItem =
  | 'Blog'
  | 'Recipe'
  | 'Shop Product'
  | 'Eatery'
  | 'Nationwide Branch';

export type SiteSearchResult = {
  type: SearchableItem;
  title: string;
  description: string;
  link: string;
  image: string;
  score?: number;
};

export type EaterySearchResult = Exclude<SiteSearchResult, 'image'> & {
  image: LatLng;
  distance?: number;
};

export type SearchResult = SiteSearchResult | EaterySearchResult;
