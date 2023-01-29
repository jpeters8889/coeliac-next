export type DefaultProps = {
  [x: string]: unknown;
  meta: MetaProps;
  navigation: {
    [T in NavigationKey]: NavigationItem[];
  };
  errors: import('@inertiajs/core').Errors & import('@inertiajs/core').ErrorBag;
};

export type MetaProps = {
  title: string,
  description: string,
  tags: string[],
  image: string,
};

export type NavigationKey = 'blogs';

export type NavigationItem = {
  title: string;
  link: string;
  description: string;
  image: string;
};
