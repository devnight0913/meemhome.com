<template>
  <div
    class="btn-back-to-top text-light justify-content-center align-items-center user-select-none mb-2 ms-auto"
    id="back_to_top"
    @click="scrollToTop"
    data-bs-toggle="tooltip"
    data-bs-placement="left"
    data-bs-title="Back to top"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 1.5rem; height: 1.5rem">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
    </svg>
  </div>
</template>

<script>
export default {
  data() {
    return {
      menu: [],
      windowHeight: window.innerHeight / 3
    };
  },
  created() {
    window.addEventListener('scroll', this.handleScroll);
  },
  methods: {
    handleScroll(event) {
      var backToTopButton = document.querySelector('#back_to_top');
      var displayStyle = window.scrollY > this.windowHeight ? 'flex' : 'none';
      backToTopButton.style.display = displayStyle;
    },
    scrollToTop() {
      window.scrollTo(0, 0);
    }
  },
  mounted() {}
};
</script>
<style>
.btn-back-to-top {
  display: none;
  width: 55px;
  height: 55px;
  z-index: 1000;
  transition: all 0.4s;
  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.3s;
  background-color: #111111;
  border-radius: 50%;
}

.btn-back-to-top:hover {
  cursor: pointer;
  background-color: #202124;
}
</style>
