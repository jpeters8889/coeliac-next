export default () => {
  const putInLocalStorage = (name: string, value: any): void => {
    localStorage.setItem(name, JSON.stringify(value));
  };

  const getFromLocalStorage = <T>(
    name: string,
    defaultValue: any = null
  ): T => {
    const rtr = localStorage.getItem(name);

    if (!rtr) {
      return defaultValue;
    }

    return JSON.parse(rtr);
  };

  const removeFromLocalStorage = (key: string): void => {
    localStorage.removeItem(key);
  };

  return { putInLocalStorage, getFromLocalStorage, removeFromLocalStorage };
};
