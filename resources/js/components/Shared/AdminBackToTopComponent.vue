<template>
  <div
    class="
      btn-back-to-top-a
      text-light
      bottom-0
      end-0
      position-fixed
      justify-content-center
      align-items-center
      user-select-none
    "
    id="back_to_top"
    @click="scrollToTop"
  >
    <MtIcon icon="keyboard_double_arrow_up"></MtIcon>
  </div>
</template>

<script>
export default {
  data() {
    return {
      menu: [],
      windowHeight: window.innerHeight / 3,
    };
  },
  created() {
    window.addEventListener("scroll", this.handleScroll);
  },
  methods: {
    handleScroll(event) {
      var backToTopButton = document.querySelector("#back_to_top");
      var displayStyle = window.scrollY > this.windowHeight ? "flex" : "none";
      backToTopButton.style.display = displayStyle;
    },
    scrollToTop() {
      window.scrollTo(0, 0);
    },
  },
  mounted() {},
};
</script>
<style>
.btn-back-to-top-a {
  display: none;
  width: 55px;
  height: 55px;
  z-index: 1000;
  transition: all 0.4s;
  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.3s;
  background-color: #0d6efd;
  border-radius: 0;
}

.btn-back-to-top-a:hover {
  cursor: pointer;
  background-color: #343a40;
  color: #fff !important;
}
</style>