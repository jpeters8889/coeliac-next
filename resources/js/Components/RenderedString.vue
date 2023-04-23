<script lang="ts">
import {
  compile, defineComponent, h, Slot, VNode,
} from 'vue';

export default defineComponent({
  render(): VNode {
    return h(compile((<Slot> this.$slots.default)()[0].children as string));
  },
});
</script>
