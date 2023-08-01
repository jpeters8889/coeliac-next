export type BaseFormInputProps = {
  modelValue: string;
  name: string;
  id?: string;
  required?: boolean;
  autocomplete?: string;
  placeholder?: string;
  borders?: boolean;
  background?: boolean;
  hasError?: boolean;
};

export const BaseFormInputPropDefaults: Partial<BaseFormInputProps> = {
  id: undefined,
  required: false,
  borders: false,
  background: true,
  hasError: false,
};

export type InputProps = BaseFormInputProps & {
  type?: 'text' | 'number' | 'search' | 'email';
  error?: string;
};

export const InputPropDefaults: Partial<InputProps> = {
  ...BaseFormInputPropDefaults,
  type: 'text',
};

export type TextareaProps = BaseFormInputProps & {
  rows?: number;
  error?: string;
};

export const TextareaPropsDefaults: Partial<TextareaProps> = {
  ...BaseFormInputPropDefaults,
  rows: 5,
};
