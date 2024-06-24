<template>
  <span
    v-if="totalItems > 0"
    class="
      position-absolute
      top-0
      start-100
      translate-middle
      badge
      rounded-pill
      bg-danger
    "
  >
    {{ totalItems }}
    <span class="visually-hidden">unread messages</span>
  </span>
</template>
<script>
import { usd_money_format } from "@/services/utils";

export default {
  data() {
    return {};
  },
  methods: {},
  created: function () {},
  computed: {
    total() {
      return usd_money_format(this.$store.state.cartTotal);
    },
    totalItems() {
      return this.$store.state.cartTotalItems;
    },
  },
};
</script>
<style>
@media (max-width: 767.98px) {
  .mx-w-100 {
    max-width: 100% !important;
  }
}
</style>