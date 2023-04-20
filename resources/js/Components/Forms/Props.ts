import { ComponentObjectPropsOptions } from 'vue';

const BaseProps: ComponentObjectPropsOptions = {
  modelValue: {
    required: true,
    type: String,
  },
  name: {
    required: true,
    type: String,
  },
  id: {
    required: false,
    type: String,
  },
  required: {
    required: false,
    type: Boolean,
    default: false,
  },
  autocomplete: {
    required: false,
    type: String,
    default: undefined,
  },
  placeholder: {
    required: false,
    type: String,
    default: undefined,
  },
  borders: {
    required: false,
    type: Boolean,
    default: false,
  },
  background: {
    required: false,
    type: Boolean,
    default: true,
  },
  hasError: {
    required: false,
    type: Boolean,
    default: false,
  },
  // validateOnBlur: {
  //   required: false,
  //   type: Boolean,
  //   default: false,
  // },
};

export const InputProps: ComponentObjectPropsOptions = {
  ...BaseProps,
  type: {
    required: false,
    type: String,
    default: 'text',
  },
};

export const TextareaProps: ComponentObjectPropsOptions = {
  ...BaseProps,
  rows: {
    required: false,
    type: Number,
    default: 5,
  },
};
