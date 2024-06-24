<template>
  <a class="nav-link position-relative" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" @click="markAsRead">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon">
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
      />
    </svg>

    <span v-if="notifications.length > 0" class="position-absolute top-0 mt-2 start-100 translate-middle badge rounded-pill bg-danger">
      {{ notifications.length }} <span class="visually-hidden">unread messages</span>
    </span>
  </a>
  <ul class="dropdown-menu dropdown-menu-end animate slideIn shadow-sm" aria-labelledby="navbarDropdown">
    <li>
      <a class="dropdown-item" v-for="notification in notifications" :key="notification.id" :href="notification.url">
        {{ notification.data }}
        <br />
        <small class="text-muted">{{ notification.created_at }} </small>
      </a>
    </li>

    <li>
      <a class="dropdown-item text-center" v-if="notifications.length == 0" href="#"> There are no notifications </a>
    </li>
  </ul>
</template>

<script>
export default {
  data() {
    return {
      notifications: []
    };
  },
  created() {
    this.getNotifications();
  },
  methods: {
    getNotifications() {
      axios
        .get('/admin/notifications')
        .then(response => {
          this.notifications = response.data.data;
        })
        .catch(({ response }) => {
          Swal.fire(`Error ${response.status}`, response.statusText, 'error');
        });
    },
    markAsRead() {
      axios
        .put('/admin/notifications/mark-as-read', null)
        .then(response => {})
        .catch(({ response }) => {
          Swal.fire(`Error ${response.status}`, response.statusText, 'error');
        });
    }
  },
  mounted() {}
};
</script>
