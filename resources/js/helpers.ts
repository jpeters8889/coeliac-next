import dayjs from 'dayjs';
import advancedFormat from 'dayjs/plugin/advancedFormat';
import { Converter } from 'any-number-to-words';

export const formatDate = (
  date: string,
  format: string = 'Do MMM YYYY',
): string => {
  dayjs.extend(advancedFormat);

  return dayjs(date).format(format);
};

export const numberToWords = (
  number: number,
  min: number = 0,
  max: number = 10,
): string => {
  if (number <= min || number >= max) {
    return number.toLocaleString();
  }

  return new Converter().toWords(number);
};

export const loadScript = (script: string) =>
  new Promise((resolve) => {
    if (document.querySelector(`script[src="${script}"]`)) {
      resolve(true);

      return;
    }

    const scriptElement = document.createElement('script');

    scriptElement.setAttribute('src', script);

    document.body.appendChild(scriptElement);

    scriptElement.addEventListener('load', resolve);
  });

export const ucfirst = (str: string): string =>
  str.charAt(0).toUpperCase() + str.slice(1);

export const pluralise = (str: string, count: number): string => {
  if (count === 1) {
    return str;
  }

  return `${str}s`;
};
