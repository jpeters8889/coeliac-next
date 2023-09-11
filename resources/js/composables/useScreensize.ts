import { ref } from 'vue';
import resolveConfig from 'tailwindcss/resolveConfig';
import { Config } from 'tailwindcss';
// @ts-ignore
import tailwindConfig from 'tailwind.config.js';
import { KeyValuePair } from 'tailwindcss/types/config';

type ScreenSize = {
  breakpoint: string;
  from: number;
  to: number;
};

export default () => {
  const fullConfig: Config = resolveConfig<Config>(tailwindConfig) as Config;

  const rawWidth = ref(window.screen.width);

  const screenConfig: KeyValuePair<string, string> = fullConfig?.theme
    ?.screens as KeyValuePair<string, string>;
  const keys: string[] = [
    'xxxs',
    ...Object.keys(screenConfig).sort((a: string, b: string) =>
      parseInt(screenConfig[a], 10) > parseInt(screenConfig[b], 10) ? 1 : -1
    ),
  ];

  const screenSizes = () =>
    keys.map((key, index): ScreenSize => {
      const nextKey = keys[index + 1];

      return {
        breakpoint: key,
        from: parseInt(screenConfig[key], 10) || 0,
        to: parseInt(screenConfig[nextKey], 10) - 1 || 9999,
      };
    });

  const currentBreakpoint = (): string => {
    let breakpoint = '';

    screenSizes().forEach((size) => {
      if (rawWidth.value >= size.from && rawWidth.value <= size.to) {
        breakpoint = size.breakpoint;
      }
    });

    return breakpoint;
  };

  const detailsForBreakpoint = (breakpoint: string): ScreenSize | undefined =>
    screenSizes().find((screenSize) => screenSize.breakpoint === breakpoint);

  const screenIsLessThanOrEqualTo = (breakpoint: string): boolean =>
    rawWidth.value <= (detailsForBreakpoint(breakpoint)?.to || 0);

  const screenIsLessThan = (breakpoint: string): boolean =>
    rawWidth.value < (detailsForBreakpoint(breakpoint)?.from || 0);

  const screenIs = (breakpoint: string): boolean =>
    rawWidth.value >= (detailsForBreakpoint(breakpoint)?.from || 0) &&
    rawWidth.value <= (detailsForBreakpoint(breakpoint)?.to || 0);

  const screenIsGreaterThan = (breakpoint: string): boolean =>
    rawWidth.value > (detailsForBreakpoint(breakpoint)?.to || 0);

  const screenIsGreaterThanOrEqualTo = (breakpoint: string): boolean =>
    rawWidth.value >= (detailsForBreakpoint(breakpoint)?.from || 0);

  return {
    rawWidth,
    screenSizes,
    currentBreakpoint,
    screenIsLessThanOrEqualTo,
    screenIsLessThan,
    screenIs,
    screenIsGreaterThan,
    screenIsGreaterThanOrEqualTo,
  };
};
