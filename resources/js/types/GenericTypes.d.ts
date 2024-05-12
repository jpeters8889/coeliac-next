export type PaginatedResponse<Data> = {
  data: Data[];
  links: {
    first: string;
    last: string;
    next?: string;
    prev?: string;
  };
  meta: {
    current_page: number;
    from: number;
    last_page: number;
    per_page: number;
    to: number;
    total: number;
  };
};

export type PaginatedCollection<Data> = {
  data: Data[];
  next_page_url?: string;
  prev_page_url?: string;
  current_page: number;
  from: number;
  last_page: number;
  per_page: number;
  to: number;
  total: number;
};

export type DataResponse<Data> = {
  data: Data;
};
