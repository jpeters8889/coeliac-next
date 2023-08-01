import { CheckboxItem } from '@/types/Types';

export type County = {
  name: string;
  title: string;
  link: string;
};

export type CountyPage = County & {
  image?: string;
  eateries: number;
  reviews: number;
  towns: CountyPageTown[];
};

export type CountyPageTown = Town & {
  link: string;
  eateries: number;
  attractions: number;
  hotels: number;
};

export type Eatery = {
  name: string;
  link: string;
  county: {
    id: number;
    name: string;
    link: string;
  };
  town: {
    id: number;
    name: string;
    link: string;
  };
  info: string;
};

export type CountyEatery = Eatery & {
  address: string;
  rating: StarRating;
  rating_count: number;
};

export type Town = {
  name: string;
  county: County;
};

export type TownPage = Town & {
  link: string;
  image?: string;
};

export type EateryFilters = {
  categories: CheckboxItem[];
  venueTypes: CheckboxItem[];
  features: CheckboxItem[];
};

export type TownEatery = Eatery & {
  type: string;
  venue_type?: string;
  cuisine?: string;
  website?: string;
  restaurants: {
    name?: string;
    info: string;
  }[];
  location: {
    address: string;
    lat: number;
    lng: number;
  };
  phone?: string;
  reviews: {
    number: number;
    average: string;
  };
};

export type StarRating =
  | 0
  | 0.5
  | 1
  | 1.0
  | 1.5
  | 2
  | 2.0
  | 2.5
  | 3
  | 3.0
  | 3.5
  | 4
  | 4.0
  | 4.5
  | 5
  | 5.0;
