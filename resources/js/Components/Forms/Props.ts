import { CheckCircleIcon as CheckCircleIconOutline } from '@heroicons/vue/24/outline';
import { CheckCircleIcon as CheckCircleIconSolid } from '@heroicons/vue/24/solid';
import { FunctionalComponent } from 'vue';

export type BaseFormProps = {
  name: string;
  id?: string;
  required?: boolean;
  autocomplete?: string;
  placeholder?: string;
  borders?: boolean;
  background?: boolean;
  hasError?: boolean;
  disabled?: boolean;
};

export type BaseFormInputProps = BaseFormProps & {
  modelValue: string;
};

export const BaseFormInputPropDefaults: Partial<BaseFormInputProps> = {
  id: undefined,
  required: false,
  borders: false,
  background: true,
  hasError: false,
  disabled: false,
};

export type InputProps = BaseFormInputProps & {
  type?: 'text' | 'number' | 'search' | 'email' | 'url' | 'phone';
  label: string;
  error?: string;
  hideLabel?: boolean;
  size?: 'default' | 'large';
  min?: number;
  max?: number;
};

export const InputPropDefaults: Partial<InputProps> = {
  ...BaseFormInputPropDefaults,
  type: 'text',
  hideLabel: false,
  size: 'default',
  min: undefined,
  max: undefined,
};

export type TextareaProps = BaseFormInputProps & {
  label: string;
  rows?: number;
  error?: string;
  max?: number;
  hideLabel?: boolean;
};

export const TextareaPropsDefaults: Partial<TextareaProps> = {
  ...BaseFormInputPropDefaults,
  rows: 5,
  max: undefined,
  hideLabel: false,
};

export type CheckboxProps = BaseFormProps & {
  modelValue: boolean;
  label: string;
};

export const CheckboxPropsDefault: Partial<CheckboxProps> = <
  Partial<CheckboxProps>
>{
  ...BaseFormInputPropDefaults,
};

export type FormSelectOption = {
  label?: string;
  value: string | number | boolean;
};

export type FormSelectProps = BaseFormProps & {
  modelValue: string | number | boolean;
  label?: string;
  options: FormSelectOption[];
  placeholder?: string;
  hideLabel?: boolean;
  error?: string;
  size?: 'default' | 'large';
};

export const FormSelectPropsDefaults: Partial<FormSelectProps> = {
  ...BaseFormInputPropDefaults,
  label: undefined,
  placeholder: 'Select an option',
  hideLabel: false,
  error: undefined,
  size: 'default',
};

export type FormStepperProps = BaseFormProps & {
  modelValue: string | number | boolean;
  label?: string;
  options: FormSelectOption[];
  selectedClass?: string | string[];
  baseClass?: string | string[];
  iconClasses?: string | string[];
  wrapperClasses?: string | string[];
  icon?: FunctionalComponent;
  unselectedIcon?: FunctionalComponent | null;
  hideOptionsText?: boolean;
  defaultText?: string;
};

export const FormStepperPropsDefaults: Partial<FormStepperProps> = {
  ...BaseFormInputPropDefaults,
  label: undefined,
  selectedClass: ['text-secondary'],
  baseClass: ['text-grey-off'],
  iconClasses: ['h-8 w-8'],
  wrapperClasses: [],
  icon: CheckCircleIconSolid,
  unselectedIcon: CheckCircleIconOutline,
  hideOptionsText: false,
  defaultText: 'Select an option',
};
