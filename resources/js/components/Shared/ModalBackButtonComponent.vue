<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    fill="none"
    viewBox="0 0 24 24"
    stroke-width="1.5"
    stroke="currentColor"
    data-bs-dismiss="modal"
    :class="`hero-icon me-md-3 me-2 cursor-pointer ${styleName}`"
  >
    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
  </svg>
</template>

<script>
export default {
  props: ['styleName'],
  data() {
    return {};
  },
  created() {},
  methods: {},
  mounted() {},
  computed: {}
};
</script>
