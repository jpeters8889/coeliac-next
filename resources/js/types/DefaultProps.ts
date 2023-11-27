export type DefaultProps = {
  [x: string]: unknown;
  meta: MetaProps;
  errors: import('@inertiajs/core').Errors & import('@inertiajs/core').ErrorBag;
};

export type MetaProps = {
  baseUrl: string;
  title: string;
  description: string;
  tags: string[];
  image: string;
  schema?: string;
  doNotTrack?: true;
  alternateMetas?: {
    [T: string]: string;
  };
};
