export default () => {
  const currentUrl = (): string =>
    window.location.origin + window.location.pathname;

  const generateUrl = (suffix: string): string => `${currentUrl()}/${suffix}`;

  return { currentUrl, generateUrl };
};
