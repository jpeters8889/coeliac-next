export type HomeHoverItem = {
  title: string;
  link: string;
  image: string;
  square_image?: string;
  type?: 'Blog' | 'Recipe';
};

export type FormItem = {
  value: string | number;
  label: string;
};

export type SelectBoxItem = FormItem & {
  disabled?: boolean;
};

export type CheckboxItem = SelectBoxItem & {
  checked?: boolean;
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

export type HeadingBackLink = {
  label: string;
  href: string;
  position?: 'top' | 'bottom';
  direction?: 'left' | 'center' | 'right';
};
