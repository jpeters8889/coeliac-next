<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import { Comment } from '@/types/Types';
import { PaginatedResponse } from '@/types/GenericTypes';
import FormInput from '@/Components/Forms/FormInput.vue';
import { useForm } from '@inertiajs/vue3';
import FormTextarea from '@/Components/Forms/FormTextarea.vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import { ref } from 'vue';

const emits = defineEmits(['load-more']);

const props = defineProps<{
  comments: PaginatedResponse<Comment>;
  module: 'blog' | 'recipe';
  id: number;
}>();

const form = useForm({
  module: props.module,
  id: props.id,
  name: '',
  email: '',
  comment: '',
});

const hasSubmitted = ref(false);

const commentSubmitting = ref(false);

const submitComment = () => {
  commentSubmitting.value = true;

  form.post('/comments', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset('name', 'email', 'comment');
      hasSubmitted.value = true;
    },
    onFinish: () => {
      commentSubmitting.value = false;
    },
  });
};
</script>

<template>
  <Card>
    <h2 class="my-2 font-coeliac text-2xl font-semibold">Your Comments</h2>

    <div
      v-if="comments.data.length"
      class="flex flex-col space-y-4"
    >
      <div
        v-for="(comment, index) in comments.data"
        :key="`${comment.name}-${index}`"
        class="flex flex-col space-y-2 border-l-8 border-secondary bg-gradient-to-br from-primary/30 to-primary-light/30 p-3 shadow"
      >
        <div
          class="prose prose-sm max-w-none md:prose-base"
          v-text="comment.comment"
        />
        <div class="flex space-x-2 text-xs font-medium text-grey">
          <span
            class="font-semibold"
            v-text="comment.name"
          />
          <span v-text="comment.published" />
        </div>
        <div
          v-if="comment.reply"
          class="mt-2 flex flex-col space-y-2 bg-white bg-opacity-80 p-3"
        >
          <div class="flex space-x-2 text-sm font-medium text-grey">
            <span
              class="font-semibold"
              v-text="'Alison @ Coeliac Sanctuary'"
            />
            <span v-text="comment.reply.published" />
          </div>
          <div
            class="prose prose-sm max-w-none md:prose-base"
            v-text="comment.reply.comment"
          />
        </div>
      </div>

      <div
        v-if="comments.links.next"
        class="hover:bg-primary-gradient-10 cursor-pointer border border-primary bg-gradient-to-br from-primary/20 to-primary-light/20 p-1 text-center text-lg shadow"
        @click="emits('load-more')"
        v-text="'Load more comments...'"
      />
    </div>

    <div
      v-else
      class="font-semibold"
    >
      There's no comments on this blog, why not leave one?
    </div>
  </Card>

  <Card>
    <h2 class="my-2 font-coeliac text-2xl font-semibold">Submit Comment</h2>

    <p>
      Want to leave a comment on this blog? Feel free to join the discussion!
    </p>

    <form
      v-if="!hasSubmitted"
      class="mt-4 flex flex-col space-y-4"
      @submit.prevent="submitComment()"
    >
      <FormInput
        id="name"
        v-model="form.name"
        :error="form.errors.name"
        autocomplete="fullname"
        label="Your Name"
        name="name"
        required
        borders
      />

      <FormInput
        id="email"
        v-model="form.email"
        :error="form.errors.email"
        autocomplete="email"
        label="Email Address"
        name="email"
        required
        borders
        type="email"
      />

      <FormTextarea
        id="comment"
        v-model="form.comment"
        :error="form.errors.comment"
        autocomplete="email"
        label="Your Comment..."
        name="comment"
        required
      />

      <small class="text-xs italic sm:text-sm md:text-base">
        Note, your email address will never be displayed with your comment, it
        is only required to alert you when your comment has been approved or if
        the Coeliac Sanctuary team reply to your comment.
      </small>

      <div class="text-center">
        <CoeliacButton
          :loading="commentSubmitting"
          as="button"
          label="Submit Comment"
          theme="light"
          type="submit"
        />
      </div>
    </form>

    <p
      v-else
      class="mx-auto mt-2 text-center text-lg font-semibold lg:w-4/5"
    >
      Thank you for submitting your comment! Your comment will be approved
      before appearing on the website.
    </p>
  </Card>
</template>
