import { HomeHoverItem } from '@/types/Types';

export type BlogDetailCard = HomeHoverItem & {
  description: string;
  date: string;
  comments_count?: string;
  tags?: BlogTag[]
};

export type BlogTag = {
  tag: string;
  slug: string;
};

export type BlogTagCount = {
  slug: string;
  tag: string;
  blogs_count: number;
};
