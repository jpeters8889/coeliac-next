import { onMounted, onUnmounted, Ref } from 'vue';

export default (
  ref: Ref<Element>,
  callback: () => void,
  options: Partial<IntersectionObserverInit> = {},
) => {
  if (typeof IntersectionObserver === 'undefined') {
    return;
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        callback();
      }
    });
  }, options);

  onMounted(() => {
    observer.observe(ref.value);
  });

  onUnmounted(() => observer.disconnect());

  return { observer };
};
