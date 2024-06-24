<template>
  <div class="d-flex align-items-center mb-3">
    <div class="flex-grow-1 h5 fw-bold m-0 ff-montserrat">Coupons</div>
    <button class="btn btn-primary px-md-4 ms-auto" data-bs-toggle="modal" data-bs-target="#couponModal">Add Coupon</button>
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
            <th>Coupon Code</th>
            <th>Percentage</th>
            <th>Description</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="coupon in couponList" :key="coupon.id">
            <td>{{ coupon.code }}</td>
            <td>{{ coupon.percentage }}%</td>
            <td>{{ coupon.description }}</td>
            <td>
              <div class="form-check form-switch">
                <input
                  class="form-check-input cursor-pointer"
                  type="checkbox"
                  id="flexSwitchCheckChecked"
                  :checked="coupon.is_active"
                  v-on:change="updateStatus(coupon.id)"
                />
                <label class="form-check-label" for="flexSwitchCheckChecked">
                  {{ coupon.status }}
                </label>
              </div>
            </td>
            <td>
              <button class="btn btn-info btn-xs me-md-2" data-bs-toggle="modal" data-bs-target="#editCouponModal" v-on:click="openEditModal(coupon)">
                Edit
              </button>

              <button class="btn btn-danger btn-xs" v-on:click="deleteCoupon(coupon.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <NoContent v-if="couponList.length == 0" />
    </div>
  </div>

  <!-- Modal Create -->
  <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable modal-dialog-centered">
      <form @submit.prevent="storeCoupon" class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="couponModalLabel">Add Coupon</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal" @click="restoreFormControl()">Discard</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="code" class="form-label fw-bold"> Coupon Code </label>
            <input
              type="text"
              class="form-control"
              maxLength="10"
              v-model="data.code"
              id="code"
              :class="{ 'is-invalid': errors.hasOwnProperty('code') }"
              name="code"
            />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('code')">
              {{ errors.code[0] }}
            </div>
            <div class="form-text">Max 10 characters</div>
          </div>
          <div class="mb-3">
            <label for="percentage" class="form-label fw-bold"> Discount Percentage </label>
            <div class="position-relative">
              <input
                type="number"
                class="form-control ps-4"
                v-model="data.percentage"
                step="0.1"
                min="0"
                max="100"
                id="percentage"
                :class="{ 'is-invalid': errors.hasOwnProperty('percentage') }"
                placeholder="0"
                autocomplete="off"
              />
              <div class="position-absolute top-50 start-0 translate-middle-y p-2 text-muted user-select-none">%</div>
            </div>
            <div class="text-danger mt-1 small" v-if="errors.hasOwnProperty('percentage')">
              {{ errors.percentage[0] }}
            </div>
          </div>
          <div>
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea
              class="form-control"
              v-model="data.description"
              id="description"
              :class="{ 'is-invalid': errors.hasOwnProperty('description') }"
            ></textarea>
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('description')">
              {{ errors.description[0] }}
            </div>
            <div class="form-text">Max 190 characters</div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Update -->
  <div class="modal fade" id="editCouponModal" tabindex="-1" aria-labelledby="editCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable modal-dialog-centered">
      <form @submit.prevent="updateCoupon(editData.id)" class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="editCouponModalLabel">Edit Coupon</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="code-edit" class="form-label fw-bold"> Coupon Code </label>
            <input
              type="text"
              class="form-control"
              maxLength="10"
              v-model="editData.code"
              id="code-edit"
              :class="{ 'is-invalid': errors.hasOwnProperty('code') }"
            />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('code')">
              {{ errors.code[0] }}
            </div>
            <div class="form-text">Max 10 characters</div>
          </div>

          <div class="mb-3">
            <label for="percentage-edit" class="form-label fw-bold"> Discount Percentage </label>
            <div class="position-relative">
              <input
                type="number"
                class="form-control ps-4"
                v-model="editData.percentage"
                step="0.1"
                min="0"
                max="100"
                id="percentage-edit"
                :class="{ 'is-invalid': errors.hasOwnProperty('percentage') }"
                placeholder="0"
                autocomplete="off"
              />
              <div class="position-absolute top-50 start-0 translate-middle-y p-2 text-muted user-select-none">%</div>
            </div>
            <div class="text-danger mt-1 small" v-if="errors.hasOwnProperty('percentage')">
              {{ errors.percentage[0] }}
            </div>
          </div>

          <div>
            <label for="des-edit" class="form-label fw-bold"> Description </label>
            <textarea
              class="form-control"
              v-model="editData.description"
              id="des-edit"
              :class="{ 'is-invalid': errors.hasOwnProperty('description') }"
            ></textarea>

            <div class="invalid-feedback" v-if="errors.hasOwnProperty('description')">
              {{ errors.description[0] }}
            </div>
            <div class="form-text">Max 190 characters</div>
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
      coupons: [],
      search: '',
      data: {
        code: '',
        percentage: 0,
        description: ''
      },
      editData: {
        id: '',
        code: '',
        percentage: 0,
        description: '',
        _method: 'PUT'
      },
      errors: {},
      loading: false
    };
  },
  mounted() {},
  methods: {
    fetchCoupons() {
      topbar.show();
      axios
        .get('/admin/coupons/all')
        .then(response => {
          this.coupons = response.data.data;
        })
        .catch(({ response }) => {
          Swal.fire(`Error ${response.status}`, response.statusText, 'error');
        })
        .then(() => {
          topbar.hide();
        });
    },
    refreshTable() {
      this.fetchCoupons();
    },

    deleteCoupon(id) {
      Swal.fire(swalConfig()).then(result => {
        if (result.value) {
          topbar.show();
          axios
            .delete(`/admin/coupons/${id}`)
            .then(response => {
              if (response.status == 200) {
                this.fetchCoupons();
                this.$toast.success('Coupon has been deleted');
              }
            })
            .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
            .then(() => topbar.hide());
        }
      });
    },
    storeCoupon() {
      this.errors = {};
      topbar.show();
      this.loading = true;

      axios
        .post('/admin/coupons', this.data)
        .then(response => {
          this.fetchCoupons();
          this.restoreFormControl();
          this.$toast.success('New Coupon Added');
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

    updateCoupon(id) {
      this.errors = {};
      topbar.show();
      this.loading = true;

      axios
        .post(`/admin/coupons/${id}`, this.editData)
        .then(response => {
          this.fetchCoupons();
          this.$toast.success('Coupon has been updated');
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

    openEditModal(coupon) {
      this.editData.id = coupon.id;
      this.editData.code = coupon.code;
      this.editData.percentage = coupon.percentage;
      this.editData.description = coupon.description;
    },

    updateStatus(id) {
      topbar.show();
      axios
        .put(`/admin/coupons/status/${id}`)
        .then(response => {
          this.fetchCoupons();
          this.$toast.success('Coupon has been updated');
        })
        .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
        .then(() => topbar.hide());
    },
    restoreFormControl() {
      this.errors = {};
      this.data.code = '';
      this.data.percentage = 0;
      this.data.description = '';
    }
  },

  created: function () {
    this.fetchCoupons();
  },
  computed: {
    couponList() {
      const search = this.search.toLowerCase();
      if (!search) return this.coupons;
      return this.coupons.filter(coupon => {
        return (
          coupon.code.toLowerCase().includes(search) ||
          coupon.percentage.toString().toLowerCase().includes(search) ||
          coupon.description.toLowerCase().includes(search)
        );
      });
    }
  }
};
</script>
