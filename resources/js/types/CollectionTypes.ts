import { HomeHoverItem } from '@/types/Types';

export type CollectionDetailCard = HomeHoverItem & {
  description: string;
  date: string;
};

export type CollectionPage = {
  id: number;
  title: string;
  image: string;
  published: string;
  updated: string;
  author: string;
  description: string;
};
