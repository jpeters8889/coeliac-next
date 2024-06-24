<script lang="ts" setup>
import { DetailedEatery, EateryNationwideBranch } from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';
import { computed, ref } from 'vue';
import { pluralise } from '../../../../helpers';
import EateryBranchListModal from '@/Components/PageSpecific/EatingOut/Details/Modals/EateryBranchListModal.vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import useScreensize from '@/composables/useScreensize';

const props = defineProps<{
  eatery: DetailedEatery;
}>();

const showModal = ref(false);

const { screenIsLessThan } = useScreensize();

const branches = computed(
  (): EateryNationwideBranch[] =>
    props.eatery.nationwide_branches as EateryNationwideBranch[],
);
</script>

<template>
  <Card
    class="space-y-2 lg:space-y-4 lg:rounded-lg lg:p-8"
    :class="$attrs.class"
  >
    <p class="prose max-w-none sm:prose-lg lg:prose-xl">
      We've currently got
      <span
        class="font-semibold"
        v-text="branches.length"
      />
      {{ pluralise('branch', branches.length) }} for
      <span
        class="font-semibold"
        v-text="eatery.name"
      />
      listed in our eating guide?
    </p>

    <CoeliacButton
      as="button"
      label="View Branches"
      theme="secondary"
      :size="screenIsLessThan('md') ? 'xxl' : 'lg'"
      classes="justify-center"
      @click="showModal = true"
      @close="showModal = false"
    />
  </Card>

  <EateryBranchListModal
    :eatery-name="eatery.name"
    :show="showModal"
    :branches="branches"
    @close="showModal = false"
  />
</template>
