<template>
  <div class="d-flex align-items-center mb-3">
    <div class="flex-grow-1 h5 fw-bold m-0 ff-montserrat">Payment Methods</div>
    <button class="btn btn-primary px-md-4 ms-auto" data-bs-toggle="modal" data-bs-target="#methodModal">Add Method</button>
  </div>
  <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="position-relative mb-3">
      <input
        type="search"
        class="form-control w-auto"
        name="search"
        v-model="search"
        id="search"
        autocomplete="off"
        placeholder="Search..."
        style="padding-left: 2.5rem !important"
      />
      <div class="position-absolute top-50 start-0 translate-middle-y p-2">
        <SearchIcon />
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover mb-0">
        <thead>
          <tr>
            <th>Method</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="method in methodList" :key="method.id">
            <td>{{ method.name }}</td>
            <td>
              <div class="form-check form-switch">
                <input
                  class="form-check-input cursor-pointer"
                  type="checkbox"
                  id="flexSwitchCheckChecked"
                  :checked="method.is_active"
                  v-on:change="updateStatus(method.id)"
                />
                <label class="form-check-label" for="flexSwitchCheckChecked">
                  {{ method.status }}
                </label>
              </div>
            </td>
            <td>
              <button class="btn btn-info btn-xs me-md-2" data-bs-toggle="modal" data-bs-target="#editMethodModal" v-on:click="openEditModal(method)">
                Edit
              </button>

              <button class="btn btn-danger btn-xs" v-on:click="deleteMethod(method.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <NoContent v-if="methodList.length == 0" />
    </div>
  </div>

  <!-- Modal Create -->
  <div class="modal fade" id="methodModal" tabindex="-1" aria-labelledby="methodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable modal-dialog-centered">
      <form @submit.prevent="storeMethod" class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="methodModalLabel">Add Method</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal" @click="restoreFormControl()">Discard</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>
        <div class="modal-body">
          <div>
            <label for="name" class="form-label fw-bold">Method Name</label>
            <input type="text" class="form-control" v-model="data.name" id="name" :class="{ 'is-invalid': errors.hasOwnProperty('name') }" name="name" />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('name')">
              {{ errors.name[0] }}
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Update -->
  <div class="modal fade" id="editMethodModal" tabindex="-1" aria-labelledby="editMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable modal-dialog-centered">
      <form @submit.prevent="updateMethod(editData.id)" class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="editMethodModalLabel">Edit Method</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>
        <div class="modal-body">
          <div>
            <label for="name-edit" class="form-label fw-bold">Method Name</label>
            <input type="text" class="form-control" v-model="editData.name" id="name-edit" :class="{ 'is-invalid': errors.hasOwnProperty('name') }" />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('name')">
              {{ errors.name[0] }}
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { swalConfig } from '@/services/utils';
export default {
  data() {
    return {
      methods: [],
      pageOfItems: [],
      search: '',
      data: {
        name: ''
      },
      editData: {
        id: '',
        name: '',
        _method: 'PUT'
      },
      errors: {},
      loading: false
    };
  },
  mounted() {},
  methods: {
    fetchMethods() {
      topbar.show();
      axios
        .get('/admin/payment_methods/all')
        .then(response => (this.methods = response.data.data))
        .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
        .then(() => topbar.hide());
    },

    deleteMethod(id) {
      Swal.fire(swalConfig()).then(result => {
        if (result.value) {
          topbar.show();
          axios
            .delete(`/admin/payment_methods/${id}`)
            .then(response => {
              if (response.status == 200) {
                this.fetchMethods();
                this.$toast.success('Method has been deleted');
              }
            })
            .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
            .then(() => topbar.hide());
        }
      });
    },
    storeMethod() {
      this.errors = {};
      topbar.show();
      this.loading = true;
      axios
        .post('/admin/payment_methods', this.data)
        .then(response => {
          this.fetchMethods();
          this.data.name = '';
          this.$toast.success('New Method Added');
        })
        .catch(({ response }) => {
          if (response.status === 422 || response.status === 429) {
            this.errors = response.data.errors;
          } else {
            Swal.fire(`Error ${response.status}`, response.statusText, 'error');
          }
        })
        .then(() => {
          topbar.hide();
          this.loading = false;
        });
    },

    updateMethod(id) {
      this.errors = {};
      topbar.show();
      this.loading = true;
      axios
        .post(`/admin/payment_methods/${id}`, this.editData)
        .then(response => {
          this.fetchMethods();
          this.$toast.success('Method has been updated');
        })
        .catch(({ response }) => {
          if (response.status === 422 || response.status === 429) {
            this.errors = response.data.errors;
          } else {
            Swal.fire(`Error ${response.status}`, response.statusText, 'error');
          }
        })
        .then(() => {
          topbar.hide();
          this.loading = false;
        });
    },
    openEditModal(method) {
      this.editData.id = method.id;
      this.editData.name = method.name;
    },

    updateStatus(id) {
      topbar.show();
      axios
        .put(`/admin/payment_methods/status/${id}`)
        .then(response => {
          this.fetchMethods();
          this.$toast.success('Method has been updated');
        })
        .catch(({ response }) => {
          Swal.fire(`Error ${response.status}`, response.statusText, 'error');
        })
        .then(() => {
          topbar.hide();
        });
    },
    restoreFormControl() {
      this.errors = {};
      this.data.name = '';
    }
  },

  created: function () {
    this.fetchMethods();
  },
  computed: {
    methodList() {
      const search = this.search.toLowerCase();
      if (!search) return this.methods;
      return this.methods.filter(method => {
        return method.name.toLowerCase().includes(search);
      });
    }
  }
};
</script>
