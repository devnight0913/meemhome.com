<template>
  <form @submit.prevent="sendMessage">
    <div class="row">
      <div class="col-md-12 mb-3">
        <input
          type="text"
          class="form-control form-control-lg p-3 px-4 shadow-sm"
          :class="{
            'is-invalid': errors.hasOwnProperty('name'),
          }"
          placeholder="Name*"
          aria-label="Name*"
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
            'is-invalid': errors.hasOwnProperty('phone'),
          }"
          placeholder="Phone Number*"
          aria-label="Phone Number*"
          v-model="data.phone"
          name="phone"
          autocomplete="phone"
        />
        <div class="invalid-feedback" v-if="errors.hasOwnProperty('phone')">
          {{ errors.phone[0] }}
        </div>
      </div>
      <div class="col-md-12 mb-3">
        <input
          type="text"
          class="form-control form-control-lg p-3 px-4 shadow-sm"
          :class="{
            'is-invalid': errors.hasOwnProperty('location'),
          }"
          placeholder="Location*"
          aria-label="Location*"
          v-model="data.location"
          name="location"
          autocomplete="location"
        />
        <div class="invalid-feedback" v-if="errors.hasOwnProperty('location')">
          {{ errors.location[0] }}
        </div>
      </div>
      <div class="col-md-12 mb-3">
        <textarea
          class="form-control form-control-lg p-3 px-4 shadow-sm"
          :class="{
            'is-invalid': errors.hasOwnProperty('description'),
          }"
          placeholder="Description*"
          aria-label="Description*"
          rows="5"
          v-model="data.description"
        ></textarea>
        <div class="invalid-feedback" v-if="errors.hasOwnProperty('description')">
          {{ errors.description[0] }}
        </div>
      </div>
    </div>

    <button
      type="submit"
      class="btn btn-primary btn-lg px-5"
      :disabled="loading"
    >
      Send
    </button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      data: {
        name: "",
        phone: "",
        location: "",
        description: "",
      },
      errors: {},
      loading: false,
    };
  },
  mounted() {},
  methods: {
    sendMessage() {
      this.errors = {};
      topbar.show();
      this.loading = true;
      axios
        .post("/issue-booking/message", this.data)
        .then((response) => {
          if (response.status === 200) {
            Swal.fire(
              "Thank You!",
              "Your message has beeen sent. We will contact you as soon as possible!",
              "success"
            );
            this.data.name = "";
            this.data.phone = "";
            this.data.location = "";
            this.data.description = "";
          }
        })
        .catch(({ response }) => {
          if (response.status === 422 || response.status === 429) {
            this.errors = response.data.errors;
          } else {
            Swal.fire(
              "Ops!",
              "An error occurred while sending the message. Please try again later",
              "warning"
            );
          }
        })
        .then(() => {
          topbar.hide();
          this.loading = false;
        });
    },
  },
  created: function () {},
  computed: {},
};
</script>