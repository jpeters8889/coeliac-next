import { useForm } from 'laravel-precognition-vue-inertia';
import { InertiaForm } from '@/types/Core';

type Payload = { email: string };

export default () => {
  const subscribeForm = useForm<Payload>('post', '/newsletter', {
    email: '',
  }) as InertiaForm<Payload>;

  return { subscribeForm };
};
