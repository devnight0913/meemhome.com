<template>
  <span :class="`material-symbols-sharp ${styleName}`">{{ icon }} </span>
</template>

<script>
export default {
  props: ["icon", "styleName"],
  data() {
    return {};
  },
  created() {},
  methods: {},
  mounted() {},
  computed: {},
};
</script>
