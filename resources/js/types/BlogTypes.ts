export type BlogSimpleCard = {
  title: string;
  link: string;
  image: string;
  description: string;
};

export type BlogDetailCard = BlogSimpleCard & {
  date: string;
  comments_count?: string;
  tags?: {
    tag: string;
    slug: string;
  }[]
};
