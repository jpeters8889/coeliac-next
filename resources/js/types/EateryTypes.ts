import { CheckboxItem } from '@/types/Types';
import { FormSelectOption } from '@/Components/Forms/Props';

export type County = {
  name: string;
  title: string;
  link: string;
};

export type CountyPage = County & {
  image?: string;
  eateries: number;
  reviews: number;
  towns: CountyPageTown[];
};

export type NationwidePage = County & {
  eateries: number;
  reviews: number;
  chains: NationwideEatery[];
};

export type CountyPageTown = Town & {
  link: string;
  eateries: number;
  attractions: number;
  hotels: number;
};

export type NationwideEatery = {
  cuisine?: string;
  info: string;
  key: number;
  link: string;
  name: string;
  phone?: string;
  reviews: {
    number: number;
    average: string;
  };
  type: string;
  venue_type?: string;
  website?: string;
};

export type Eatery = {
  name: string;
  link: string;
  county: {
    id: number;
    name: string;
    link: string;
  };
  town: {
    id: number;
    name: string;
    link: string;
  };
  info: string;
};

export type CountyEatery = Eatery & {
  address: string;
  rating: StarRating;
  rating_count: number;
};

export type Town = {
  name: string;
  county: County;
};

export type TownPage = Town & {
  link: string;
  image?: string;
};

export type EateryFilters = {
  categories: CheckboxItem[];
  venueTypes: CheckboxItem[];
  features: CheckboxItem[];
};

export type TownEatery = Eatery & {
  key: string;
  link: string;
  type: string;
  venue_type?: string;
  cuisine?: string;
  website?: string;
  restaurants: {
    name?: string;
    info: string;
  }[];
  location: EateryLocation;
  phone?: string;
  reviews: {
    number: number;
    average: string;
  };
  isNationwideBranch?: boolean;
  branch?: EateryNationwideBranch;
};

export type EateryLocation = {
  address: string;
  lat: number;
  lng: number;
};

export type EateryNationwideBranch = {
  name?: string;
  location: EateryLocation;
  link: string;
  county: {
    id: number;
    name: string;
    link: string;
  };
  town: {
    id: number;
    name: string;
    link: string;
  };
};

export type DetailedEatery = Exclude<TownEatery, 'key'> & {
  id: number;
  menu?: string;
  reviews: {
    number: number;
    average: string;
    expense?: {
      value: string;
      label: string;
    };
    has_rated: boolean;
    images?: ReviewImage[];
    admin_review?: Exclude<EateryReview, ['id', 'name']>;
    user_reviews: EateryReview[];
  };
  features?: {
    name: string;
    slug: string;
  }[];
  opening_times?: {
    is_open_now: boolean;
    today: OpeningTime;
    days: {
      [T in Days]: OpeningTime;
    };
  };
};

export type Days =
  | 'monday'
  | 'tuesday'
  | 'wednesday'
  | 'thursday'
  | 'friday'
  | 'saturday'
  | 'sunday';

export type OpeningTime = {
  opens: string;
  closes: string;
};

export type EateryReview = {
  id: string;
  published: string;
  date_diff: string;
  body?: string;
  name?: string;
  rating: StarRating;
  expense?: {
    value: string;
    label: string;
  };
  food_rating?: string;
  service_rating?: string;
  branch_name?: string;
  images: ReviewImage[];
};

export type ReviewImage = {
  id: string;
  thumbnail: string;
  path: string;
};

export type StarRating =
  | 0
  | 0.5
  | 1
  | 1.0
  | 1.5
  | 2
  | 2.0
  | 2.5
  | 3
  | 3.0
  | 3.5
  | 4
  | 4.0
  | 4.5
  | 5
  | 5.0;

export type EditableEateryData = {
  address: string;
  website?: string;
  gf_menu_link?: string;
  phone?: string;
  type_id: number;
  venue_type: EditableEaterySelectableData;
  cuisine: EditableEaterySelectableData;
  opening_times: {
    [T in Days | 'today']: [null, null] | [string, string];
  };
  features: {
    selected: {
      id: number;
      label: string;
    }[];
    values: EditableEaterySelectableData['values'];
  };
  is_nationwide: boolean;
};

type EditableEaterySelectableData = {
  id: number;
  label: string;
  values: {
    value: number;
    label: string;
    selected: boolean;
  }[];
};

type BaseEditableEateryField = {
  id: string;
  label: string;
  shouldDisplay: boolean;
  getter: () => string | null;
  capitalise?: boolean;
  truncate?: boolean;
  isFormField: boolean;
  updated: boolean;
};

type BaseEditableEateryFieldForm = BaseEditableEateryField & {
  isFormField: true;
  formField: EditableEateryFieldComponent & {
    value: () => string | number;
  };
};

type BaseEditableEateryFieldComponent = BaseEditableEateryField & {
  isFormField: false;
  component: EditableEateryFieldComponent & {
    change: (value: Object[]) => void;
  };
};

export type EditableEateryField =
  | BaseEditableEateryFieldForm
  | BaseEditableEateryFieldComponent;

type EditableEateryFieldComponent = {
  component: string;
  props?: Partial<any>;
};

export type EateryCountryListProp = {
  [T: string]: EateryCountryPropItem;
};

export type EateryCountryPropItem = {
  list: EateryCountryList[];
  counties: number;
  eateries: number;
};

export type EateryCountryList = {
  name: string;
  slug: string;
  eateries: number;
  branches: number;
  attractions: number;
  hotels: number;
  total: number;
};
