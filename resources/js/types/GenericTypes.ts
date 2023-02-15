export type PaginatedResponse<Data> = {
  data: Data[],
  links: {
    first: string;
    last: string;
    next?: string;
    prev?: string;
  }
  meta: {
    current_page: number;
    from: number;
    last_page: number;
    per_page: number;
    to: number;
    total: number;
  }
};
