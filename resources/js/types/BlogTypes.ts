export type BlogSimpleCard = {
  title: string;
  link: string;
  image: string;
  description: string;
};

export type BlogDetailCard = BlogSimpleCard & {
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
