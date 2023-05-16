import { HomeHoverItem } from '@/types/Types';

export type CollectionDetailCard = HomeHoverItem & {
  description: string;
  date: string;
  number_of_items: number;
};

export type CollectionPage = {
  id: number;
  title: string;
  image: string;
  published: string;
  updated: string;
  author: string;
  description: string;
  body?: string;
  items: CollectionItem[];
};

export type CollectionItem = {
  type: 'Blog' | 'Recipe',
  title: string;
  description: string;
  image: string;
  square_image?: string;
  date: string;
  link: string;
};

export type HomepageCollection = {
  title: string;
  description: string;
  link: string;
  items: HomepageCollectedItem[];
};

export type HomepageCollectedItem = {
  type: 'Blog' | 'Recipe',
  title: string;
  image: string;
  square_image?: string;
  link: string;
};

export type FeaturedInCollection = {
  title: string;
  link: string;
};
