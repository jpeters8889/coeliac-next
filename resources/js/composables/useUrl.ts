import useBrowser from '@/composables/useBrowser';

export default () => {
  const currentUrl = (): string => useBrowser().absoluteUrl();

  const generateUrl = (suffix: string): string => `${currentUrl()}/${suffix}`;

  return { currentUrl, generateUrl };
};
