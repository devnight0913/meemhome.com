<template>
  <form @submit.prevent="login">
    <div class="form-floating mb-3">
      <input
        type="text"
        class="form-control"
        v-model="data.email"
        id="login-email-input"
        :class="{ 'is-invalid': errors.hasOwnProperty('email') }"
        name="email"
        placeholder="Email"
        autocomplete="email"
      />
      <label for="login-email-input"> Email </label>
      <div class="invalid-feedback" v-if="errors.hasOwnProperty('email')">
        {{ errors.email[0] }}
      </div>
    </div>

    <div class="form-floating mb-3">
      <input
        type="password"
        class="form-control"
        v-model="data.password"
        id="login-password-input"
        :class="{ 'is-invalid': errors.hasOwnProperty('password') }"
        name="Password"
        placeholder="Password"
        autocomplete="password"
      />
      <label for="login-password-input"> Password</label>
      <div class="invalid-feedback" v-if="errors.hasOwnProperty('password')">
        {{ errors.password[0] }}
      </div>
    </div>

    <button type="submit" class="btn btn-lg btn-primary w-100" :disabled="loading">LOGIN</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      data: {
        email: '',
        password: ''
      },
      errors: {},
      loading: false
    };
  },
  mounted() {},
  methods: {
    login() {
      this.errors = {};
      topbar.show();
      this.loading = true;

      axios
        .post('/admin/login', this.data)
        .then(response => {
          if (response.status === 200) {
            location.href = '/admin/dashboard';
          }
        })
        .catch(({ response }) => {
          if (response.status === 422 || response.status === 429) {
            this.errors = response.data.errors;
          } else {
            Swal.fire('Error ' + response.status, response.data, 'error');
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
