export type HomeHoverItem = {
  title: string;
  link: string;
  image: string;
};

export type SelectBoxItem = {
  value: string | number;
  label: string;
  disabled?: boolean;
};

export type Comment = {
  name: string;
  comment: string;
  published: string;
  reply?: CommentReply;
};

export type CommentReply = {
  comment: string;
  published: string;
};
