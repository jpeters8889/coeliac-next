import { onMounted, onUnmounted, Ref } from 'vue';

export default (
  ref: Ref<Element>,
  callback: Function,
  options: Partial<IntersectionObserverInit> = {}
) => {
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
};
