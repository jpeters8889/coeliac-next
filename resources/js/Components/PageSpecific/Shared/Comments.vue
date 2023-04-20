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

const props = defineProps({
  comments: {
    required: true,
    type: Object as () => PaginatedResponse<Comment>,
  },
  module: {
    required: true,
    type: String,
    validator: (value: string) => ['blog', 'recipe'].includes(value),
  },
  id: {
    required: true,
    type: Number,
  },
});

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
    <h2 class="text-2xl my-2 font-semibold font-coeliac">
      Your Comments
    </h2>

    <div
      v-if="comments.data.length"
      class="flex flex-col space-y-4"
    >
      <div
        v-for="(comment, index) in comments.data"
        :key="`${comment.name}-${index}`"
        class="flex flex-col space-y-2 bg-gradient-to-br from-primary/30 to-primary-light/30 p-3 border-l-8 border-secondary shadow"
      >
        <div
          class="prose prose-sm"
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
          class="flex mt-2 flex-col space-y-2 bg-white bg-opacity-80 p-3"
        >
          <div class="flex space-x-2 text-sm font-medium text-grey">
            <span
              class="font-semibold"
              v-text="'Alison @ Coeliac Sanctuary'"
            />
            <span v-text="comment.reply.published" />
          </div>
          <div
            class="prose prose-sm"
            v-text="comment.reply.comment"
          />
        </div>
      </div>

      <div
        v-if="comments.links.next"
        class="bg-gradient-to-br from-primary/20 to-primary-light/20 p-1 shadow border border-primary text-center text-lg hover:bg-primary-gradient-10 cursor-pointer"
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
    <h2 class="text-2xl my-2 font-semibold font-coeliac">
      Submit Comment
    </h2>

    <p>Want to leave a comment on this blog? Feel free to join the discussion!</p>

    <form
      v-if="!hasSubmitted"
      class="mt-4 flex flex-col space-y-4"
      @submit.prevent="submitComment()"
    >
      <FormInput
        id="name"
        v-model="form.name"
        name="name"
        label="Your Name"
        autocomplete="fullname"
        :error="form.errors.name"
        required
      />

      <FormInput
        id="email"
        v-model="form.email"
        name="email"
        type="email"
        label="Email Address"
        autocomplete="email"
        :error="form.errors.email"
        required
      />

      <FormTextarea
        id="comment"
        v-model="form.comment"
        name="comment"
        label="Your Comment..."
        autocomplete="email"
        :error="form.errors.comment"
        required
      />

      <small class="text-xs italic">
        Note, your email address will never be displayed with your comment, it is only required to alert you when your comment has been
        approved or if the Coeliac Sanctuary team reply to your comment.
      </small>

      <div class="text-center">
        <CoeliacButton
          label="Submit Comment"
          as="button"
          type="submit"
          theme="light"
          :loading="commentSubmitting"
        />
      </div>
    </form>

    <p
      v-else
      class="text-lg font-semibold text-center mt-2 lg:w-4/5 mx-auto"
    >
      Thank you for submitting your comment! Your comment will be approved before appearing on the website.
    </p>
  </Card>
</template>
