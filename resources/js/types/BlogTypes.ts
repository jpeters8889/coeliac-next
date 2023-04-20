import { HomeHoverItem } from '@/types/Types';

export type BlogDetailCard = HomeHoverItem & {
  description: string;
  date: string;
  comments_count?: number;
  tags?: BlogTag[]
};

export type BlogPage = {
    id: number;
  title: string;
  image: string;
  published: string;
  updated: string | null;
  description: string;
  body: string;
  tags: BlogTag[];
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
