<template>
  <div class="d-flex align-items-center mb-3">
    <div class="flex-grow-1 h5 fw-bold m-0 ff-montserrat">Delivery Areas</div>
    <button class="btn btn-primary px-md-4 ms-auto" data-bs-toggle="modal" data-bs-target="#areaModal">Add Area</button>
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
            <th>Area Name</th>
            <th>Delivery Charge</th>
            <th>Delivery Time</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="area in areaList" :key="area.id">
            <td>{{ area.name }}</td>
            <td>{{ area.view_fee }}</td>
            <td>{{ area.view_time }}</td>
            <td>
              <div class="form-check form-switch">
                <input
                  class="form-check-input cursor-pointer"
                  type="checkbox"
                  id="flexSwitchCheckChecked"
                  :checked="area.is_active"
                  v-on:change="updateStatus(area.id)"
                />
                <label class="form-check-label" for="flexSwitchCheckChecked">
                  {{ area.status }}
                </label>
              </div>
            </td>
            <td>
              <button class="btn btn-info btn-xs me-md-2" data-bs-toggle="modal" data-bs-target="#editAreaModal" v-on:click="openEditModal(area)">Edit</button>

              <button class="btn btn-danger btn-xs" v-on:click="deleteArea(area.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <NoContent v-if="areaList.length == 0" />
    </div>
  </div>

  <!-- Modal Create -->
  <div class="modal fade" id="areaModal" tabindex="-1" aria-labelledby="areaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable modal-dialog-centered">
      <form @submit.prevent="storeArea" class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="areaModalLabel">Add Area</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal" @click="restoreFormControl()">Discard</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Area Name</label>
            <input type="text" class="form-control" v-model="data.name" id="name" :class="{ 'is-invalid': errors.hasOwnProperty('name') }" name="name" />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('name')">
              {{ errors.name[0] }}
            </div>
          </div>

          <div class="mb-3">
            <label for="fee" class="form-label fw-bold"> Delivery Charge</label>
            <div class="position-relative">
              <input
                type="number"
                class="form-control ps-4"
                v-model="data.fee"
                placeholder="0.00"
                autocomplete="off"
                step="0.01"
                min="0"
                id="fee"
                :class="{ 'is-invalid': errors.hasOwnProperty('fee') }"
              />
              <div class="position-absolute top-50 start-0 translate-middle-y p-2 text-muted user-select-none">$</div>
            </div>
            <div class="text-danger mt-1 small" v-if="errors.hasOwnProperty('fee')">
              {{ errors.fee[0] }}
            </div>
          </div>

          <div>
            <label for="time" class="form-label fw-bold"> Delivery time </label>
            <div>
              <InputNumber v-model="data.time" suffix=" Minutes" placeholder="0" min="0" :class="{ 'p-invalid': errors.hasOwnProperty('time') }" />
            </div>
            <div class="text-danger mt-1 small" v-if="errors.hasOwnProperty('time')">
              {{ errors.time[0] }}
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Update -->
  <div class="modal fade" id="editAreaModal" tabindex="-1" aria-labelledby="editAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable modal-dialog-centered">
      <form @submit.prevent="updateArea(editData.id)" class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="editAreaModalLabel">Edit Area</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name-edit" class="form-label fw-bold">Area Name</label>
            <input type="text" class="form-control" v-model="editData.name" id="name-edit" :class="{ 'is-invalid': errors.hasOwnProperty('name') }" />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('name')">
              {{ errors.name[0] }}
            </div>
          </div>
          <div class="mb-3">
            <label for="fee-edit" class="form-label fw-bold"> Delivery Charge</label>
            <div class="position-relative">
              <input
                type="number"
                class="form-control ps-4"
                v-model="editData.fee"
                placeholder="0.00"
                autocomplete="off"
                step="0.01"
                min="0"
                id="fee-edit"
                :class="{ 'is-invalid': errors.hasOwnProperty('fee') }"
              />
              <div class="position-absolute top-50 start-0 translate-middle-y p-2 text-muted user-select-none">$</div>
            </div>
            <div class="text-danger mt-1 small" v-if="errors.hasOwnProperty('fee')">
              {{ errors.fee[0] }}
            </div>
          </div>

          <div>
            <label for="time" class="form-label fw-bold"> Delivery time </label>
            <div>
              <InputNumber v-model="editData.time" suffix=" Minutes" placeholder="0" min="0" :class="{ 'p-invalid': errors.hasOwnProperty('time') }" />
            </div>
            <div class="text-danger mt-1 small" v-if="errors.hasOwnProperty('time')">
              {{ errors.time[0] }}
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { swalConfig } from '@/services/utils';
import InputNumber from 'primevue/inputnumber';

export default {
  components: { InputNumber },

  data() {
    return {
      areas: [],
      search: '',
      data: {
        name: '',
        fee: '',
        time: ''
      },

      editData: {
        id: '',
        name: '',
        fee: 0,
        time: 0,
        _method: 'PUT'
      },
      errors: {},
      loading: false
    };
  },
  mounted() {},
  methods: {
    fetchAreas() {
      topbar.show();
      axios
        .get('/admin/areas/all')
        .then(response => (this.areas = response.data.data))
        .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
        .then(() => topbar.hide());
    },
    refreshTable() {
      this.fetchAreas();
    },

    deleteArea(id) {
      Swal.fire(swalConfig()).then(result => {
        if (result.value) {
          topbar.show();
          axios
            .delete(`/admin/areas/${id}`)
            .then(response => {
              if (response.status == 200) {
                this.fetchAreas();
                this.$toast.success('Area has been deleted');
              }
            })
            .catch(({ response }) => {
              Swal.fire(`Error ${response.status}`, response.statusText, 'error');
            })
            .then(() => {
              topbar.hide();
            });
        }
      });
    },
    storeArea() {
      this.errors = {};
      topbar.show();
      this.loading = true;
      axios
        .post('/admin/areas', this.data)
        .then(response => {
          this.fetchAreas();
          this.restoreFormControl();
          this.$toast.success('New area added');
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

    updateArea(id) {
      this.errors = {};
      topbar.show();
      this.loading = true;

      axios
        .post(`/admin/areas/${id}`, this.editData)
        .then(response => {
          this.fetchAreas();
          this.$toast.success('Area has been updated');
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
    openEditModal(area) {
      this.editData.id = area.id;
      this.editData.name = area.name;
      this.editData.fee = area.fee;
      this.editData.time = area.time;
    },

    updateStatus(id) {
      topbar.show();
      axios
        .put(`/admin/areas/status/${id}`)
        .then(response => {
          this.fetchAreas();
          this.$toast.success('Area has been updated');
        })
        .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
        .then(() => topbar.hide());
    },
    restoreFormControl() {
      this.errors = {};
      this.data.name = '';
      this.data.fee = 0;
      this.data.time = 0;
    }
  },

  created: function () {
    this.fetchAreas();
  },
  computed: {
    areaList() {
      const search = this.search.toLowerCase();
      if (!search) return this.areas;
      return this.areas.filter(area => {
        return (
          area.name.toLowerCase().includes(search) ||
          area.view_fee.toString().toLowerCase().includes(search) ||
          area.time.toString().toLowerCase().includes(search)
        );
      });
    }
  }
};
</script>
