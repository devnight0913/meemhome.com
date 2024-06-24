<template>
  <form @submit.prevent="sendMessage">
    <div class="row">
      <div class="col-md-12 mb-3">
        <input
          type="text"
          class="form-control form-control-lg p-3 px-4 shadow-sm"
          :class="{
            'is-invalid': errors.hasOwnProperty('name')
          }"
          placeholder="Your Name*"
          aria-label="Your Name*"
          v-model="data.name"
          name="name"
          autocomplete="name"
        />
        <div class="invalid-feedback" v-if="errors.hasOwnProperty('name')">
          {{ errors.name[0] }}
        </div>
      </div>
      <div class="col-md-12 mb-3">
        <input
          type="text"
          class="form-control form-control-lg p-3 px-4 shadow-sm"
          :class="{
            'is-invalid': errors.hasOwnProperty('email')
          }"
          placeholder="Your Email*"
          aria-label="Your Email*"
          v-model="data.email"
          name="email"
          autocomplete="email"
        />
        <div class="invalid-feedback" v-if="errors.hasOwnProperty('email')">
          {{ errors.email[0] }}
        </div>
      </div>

      <div class="col-md-12 mb-3">
        <textarea
          class="form-control form-control-lg p-3 px-4 shadow-sm rounded-4"
          :class="{
            'is-invalid': errors.hasOwnProperty('message')
          }"
          placeholder="Your Message*"
          aria-label="Your Message*"
          rows="5"
          v-model="data.message"
        ></textarea>
        <div class="invalid-feedback" v-if="errors.hasOwnProperty('message')">
          {{ errors.message[0] }}
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-dark bg-black btn-lg px-5" :disabled="loading">Send Message</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      data: {
        name: '',
        email: '',
        message: ''
      },
      errors: {},
      loading: false
    };
  },
  mounted() {},
  methods: {
    sendMessage() {
      this.errors = {};
      topbar.show();
      this.loading = true;
      axios
        .post('/contact/message', this.data)
        .then(response => {
          if (response.status === 200) {
            Swal.fire('Thank You!', 'Your message has beeen sent. We will contact you as soon as possible!', 'success');
            this.data.name = '';
            this.data.email = '';
            this.data.message = '';
          }
        })
        .catch(({ response }) => {
          if (response.status === 422 || response.status === 429) {
            this.errors = response.data.errors;
          } else {
            Swal.fire('Ops!', 'An error occurred while sending the message. Please try again later', 'warning');
          }
        })
        .then(() => {
          topbar.hide();
          this.loading = false;
        });
    }
  },
  created: function () {},
  computed: {}
};
</script>
