export default () => {
  const googleEvent = (key: string, event: string, attributes: object = {}) => {
    if (!window.gtag) {
      return;
    }

    window.gtag(key, event, attributes);
  };

  return { googleEvent };
};