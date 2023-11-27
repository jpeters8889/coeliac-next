import { ref } from 'vue';
import resolveConfig from 'tailwindcss/resolveConfig';
import { Config } from 'tailwindcss';
// @ts-ignore
import tailwindConfig from 'tailwind.config.js';
import { KeyValuePair } from 'tailwindcss/types/config';

type BreakPoint =
  | 'xxxs'
  | 'xxs'
  | 'xs'
  | 'sm'
  | 'xmd'
  | 'md'
  | 'lg'
  | 'xl'
  | '2xl';

type ScreenSize = {
  breakpoint: BreakPoint;
  from: number;
  to: number;
};

type ScreenConfig = KeyValuePair<BreakPoint, string>;

export default () => {
  const fullConfig: Config = resolveConfig<Config>(tailwindConfig) as Config;

  const rawWidth = ref(window.screen.width);

  const screenConfig: ScreenConfig = fullConfig?.theme?.screens as ScreenConfig;

  const objectKeys: BreakPoint[] = Object.keys(screenConfig) as BreakPoint[];

  const keys: BreakPoint[] = [
    'xxxs',
    ...objectKeys.sort((a: BreakPoint, b: BreakPoint) =>
      parseInt(screenConfig[a], 10) > parseInt(screenConfig[b], 10) ? 1 : -1
    ),
  ];

  const screenSizes = (): {
    breakpoint: BreakPoint;
    from: number;
    to: number;
  }[] =>
    keys.map((key, index): ScreenSize => {
      const nextKey = keys[index + 1];

      return {
        breakpoint: key,
        from: parseInt(screenConfig[key], 10) || 0,
        to: parseInt(screenConfig[nextKey], 10) - 1 || 9999,
      };
    });

  const currentBreakpoint = (): BreakPoint => {
    let breakpoint: BreakPoint = 'xxxs';

    screenSizes().forEach((size) => {
      if (rawWidth.value >= size.from && rawWidth.value <= size.to) {
        breakpoint = size.breakpoint;
      }
    });

    return breakpoint;
  };

  const detailsForBreakpoint = (
    breakpoint: BreakPoint
  ): ScreenSize | undefined =>
    screenSizes().find((screenSize) => screenSize.breakpoint === breakpoint);

  const screenIsLessThanOrEqualTo = (breakpoint: BreakPoint): boolean =>
    rawWidth.value <= (detailsForBreakpoint(breakpoint)?.to || 0);

  const screenIsLessThan = (breakpoint: BreakPoint): boolean =>
    rawWidth.value < (detailsForBreakpoint(breakpoint)?.from || 0);

  const screenIs = (breakpoint: BreakPoint): boolean =>
    rawWidth.value >= (detailsForBreakpoint(breakpoint)?.from || 0) &&
    rawWidth.value <= (detailsForBreakpoint(breakpoint)?.to || 0);

  const screenIsGreaterThan = (breakpoint: BreakPoint): boolean =>
    rawWidth.value > (detailsForBreakpoint(breakpoint)?.to || 0);

  const screenIsGreaterThanOrEqualTo = (breakpoint: BreakPoint): boolean =>
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
