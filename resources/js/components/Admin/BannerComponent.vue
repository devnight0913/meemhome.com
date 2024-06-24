<template>
  <div class="d-flex align-items-center mb-3">
    <div class="flex-grow-1 h5 fw-bold m-0 ff-montserrat">Banners</div>
    <button class="btn btn-primary px-md-4 ms-auto" data-bs-toggle="modal" data-bs-target="#bannerModal">Add Banner</button>
  </div>

  <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover mb-0">
        <thead>
          <tr>
            <th>Image</th>
            <th>Sort Order</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="banner in bannerList" :key="banner.id">
            <td>
              <img :src="banner.image_url" alt="banner" class="object-fit-cover rounded-3" style="width: 570px; height: 190px" />
            </td>
            <td>{{ banner.sort_order }}</td>
            <td>
              <div class="form-check form-switch">
                <input
                  class="form-check-input cursor-pointer"
                  type="checkbox"
                  id="flexSwitchCheckChecked"
                  :checked="banner.is_active"
                  v-on:change="updateStatus(banner.id)"
                />
                <label class="form-check-label" for="flexSwitchCheckChecked">
                  {{ banner.status }}
                </label>
              </div>
            </td>
            <td>
              <button class="btn btn-info btn-xs me-md-2" data-bs-toggle="modal" data-bs-target="#editBannerModal" v-on:click="openEditModal(banner)">
                Edit
              </button>

              <button class="btn btn-danger btn-xs" v-on:click="deleteBanner(banner.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <NoContent v-if="bannerList.length == 0" />
    </div>
  </div>

  <!-- Modal Create -->
  <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable modal-dialog-centered">
      <form @submit.prevent="storeBanner" class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="bannerModalLabel">Add Banner</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal" @click="restoreFormControl()">Discard</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>
        <div class="modal-body">
          <div class="mb-3 text-center">
            <label
              for="input-image"
              class="cursor-pointer position-relative rounded-3"
              :class="{
                'border border-dark': !imageUrl
              }"
              style="width: 100%; height: 190px"
            >
              <img
                :src="imageUrl"
                class="rounded-3 object-fit-cover border border-dark"
                alt="placeholder-image"
                style="width: 100%; height: 190px"
                v-if="imageUrl"
              />
              <div class="position-absolute top-50 start-50 translate-middle" v-if="!imageUrl">
                <div class="">
                  <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 96 960 960" width="48">
                    <path
                      d="M180 936q-24.75 0-42.375-17.625T120 876V276q0-24.75 17.625-42.375T180 216h409v60H180v600h600V468h60v408q0 24.75-17.625 42.375T780 936H180Zm520-498v-81h-81v-60h81v-81h60v81h81v60h-81v81h-60ZM240 774h480L576 582 449 749l-94-124-115 149Zm-60-498v600-600Z"
                    />
                  </svg>
                </div>
                <div class="fw-bold">Choose Image</div>
              </div>
            </label>

            <div class="text-danger" v-if="errors.hasOwnProperty('image')">
              {{ errors.image[0] }}
            </div>
            <input id="input-image" class="d-none" type="file" name="input-image" accept="image/x-png, image/jpeg, image/jpg" value="" @change="openImage" />
          </div>

          <div class="mb-3">
            <label for="sort_order" class="form-label fw-bold"> Sort Order </label>
            <input
              type="number"
              class="form-control"
              v-model="data.sort_order"
              step="1"
              min="0"
              F
              id="sort_order"
              :class="{ 'is-invalid': errors.hasOwnProperty('sort_order') }"
            />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('sort_order')">
              {{ errors.sort_order[0] }}
            </div>
          </div>

          <div class="mb-3">
            <label for="alt" class="form-label fw-bold">alt</label>
            <input type="text" class="form-control" v-model="data.alt" id="alt" :class="{ 'is-invalid': errors.hasOwnProperty('alt') }" name="alt" />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('alt')">
              {{ errors.alt[0] }}
            </div>
            <div class="form-text">an alternate text for an image, if the image cannot be displayed</div>
          </div>
          <div class="mb-3">
            <label for="url" class="form-label fw-bold">URL</label>
            <input type="text" class="form-control" v-model="data.url" id="url" :class="{ 'is-invalid': errors.hasOwnProperty('url') }" name="url" />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('url')">
              {{ errors.url[0] }}
            </div>
          </div>
          <div class="mb-3">
            <label for="target" class="form-label fw-bold">Target</label>
            <select class="form-select" :class="{ 'is-invalid': errors.hasOwnProperty('target') }" name="target" v-model="data.target" id="target">
              <option value="_self">_self</option>
              <option value="_blank">_blank</option>
            </select>
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('target')">
              {{ errors.target[0] }}
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Update -->
  <div class="modal fade" id="editBannerModal" tabindex="-1" aria-labelledby="editBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable modal-dialog-centered">
      <form @submit.prevent="updateBanner(editData.id)" class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="editBannerModalLabel">Edit Banner</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>

        <div class="modal-body">
          <div class="mb-3 text-center">
            <label
              for="input-image-edit"
              class="cursor-pointer position-relative rounded-3"
              :class="{
                'border border-dark': !editData.image_url
              }"
              style="width: 100%; height: 190px"
            >
              <img
                :src="editData.image_url"
                class="rounded-3 object-fit-cover border border-dark"
                alt="placeholder-image"
                style="width: 100%; height: 190px"
                v-if="editData.image_url"
              />
              <div class="position-absolute top-50 start-50 translate-middle" v-if="!editData.image_url">Choose Image</div>
            </label>

            <div class="text-danger" v-if="errors.hasOwnProperty('image')">
              {{ errors.image[0] }}
            </div>
            <input
              id="input-image-edit"
              class="d-none"
              type="file"
              name="input-image-edit"
              accept="image/x-png, image/jpeg, image/jpg"
              value=""
              @change="openImageEdit"
            />
          </div>
          <div class="mb-3">
            <label for="sort_order-edit" class="form-label fw-bold"> Sort Order </label>
            <input
              type="number"
              class="form-control"
              v-model="editData.sort_order"
              step="0.1"
              min="0"
              id="sort_order-edit"
              :class="{ 'is-invalid': errors.hasOwnProperty('sort_order') }"
            />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('sort_order')">
              {{ errors.sort_order[0] }}
            </div>
          </div>
          <div class="mb-3">
            <label for="alt" class="form-label fw-bold">alt</label>
            <input type="text" class="form-control" v-model="editData.alt" id="alt" :class="{ 'is-invalid': errors.hasOwnProperty('alt') }" name="alt" />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('alt')">
              {{ errors.alt[0] }}
            </div>
            <div class="form-text">an alternate text for an image, if the image cannot be displayed</div>
          </div>
          <div class="mb-3">
            <label for="url" class="form-label fw-bold">URL</label>
            <input type="text" class="form-control" v-model="editData.url" id="url" :class="{ 'is-invalid': errors.hasOwnProperty('url') }" name="url" />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('url')">
              {{ errors.url[0] }}
            </div>
          </div>
          <div class="mb-3">
            <label for="target" class="form-label fw-bold">Target</label>
            <select class="form-select" :class="{ 'is-invalid': errors.hasOwnProperty('target') }" name="target" v-model="editData.target" id="target">
              <option value="_self">_self</option>
              <option value="_blank">_blank</option>
            </select>
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('target')">
              {{ errors.target[0] }}
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import FileUpload from 'primevue/fileupload';
import { swalConfig } from '@/services/utils';

export default {
  components: { FileUpload },
  data() {
    return {
      editor: ClassicEditor,
      editorConfig: {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
      },
      banners: [],
      pageOfItems: [],
      search: '',
      data: {
        image: '',
        url: '',
        target: '',
        alt: '',
        sort_order: 1
      },
      imageUrl: '',
      editData: {
        image_url: '',
        image_path: '',
        image: '',
        url: '',
        target: '',
        alt: '',
        sort_order: 1
      },
      errors: {},
      loading: false,
      loadingData: true
    };
  },
  mounted() {},
  methods: {
    fetchBanners() {
      topbar.show();
      axios
        .get('/admin/bnrs/all')
        .then(response => (this.banners = response.data.data))
        .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
        .finally(() => {
          topbar.hide();
          this.loadingData = false;
        });
    },
    deleteBanner(id) {
      Swal.fire(swalConfig()).then(result => {
        if (result.value) {
          topbar.show();
          axios
            .delete(`/admin/bnrs/${id}`)
            .then(response => {
              if (response.status == 200) {
                this.fetchBanners();
                this.$toast.success('Banner deleted');
              }
            })
            .catch(({ response }) => {
              Swal.fire('Error ' + response.status, response.statusText, 'error');
            })
            .then(() => {
              topbar.hide();
            });
        }
      });
    },
    storeBanner() {
      this.errors = {};
      topbar.show();
      this.loading = true;
      const formData = new FormData();
      formData.append('image', this.data.image);
      formData.append('sort_order', this.data.sort_order);
      formData.append('url', this.data.url || '');
      formData.append('target', this.data.target || '');
      formData.append('alt', this.data.alt || '');

      const config = { headers: { 'Content-Type': 'multipart/form-data' } };
      axios
        .post('/admin/bnrs', formData, config)
        .then(response => {
          this.fetchBanners();
          this.restoreFormControl();
          this.$toast.success('Banner has been added');
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

    updateBanner(id) {
      this.errors = {};
      topbar.show();
      this.loading = true;
      const formData = new FormData();
      formData.append('image', this.editData.image);
      formData.append('sort_order', this.editData.sort_order);
      formData.append('url', this.editData.url || '');
      formData.append('target', this.editData.target || '');
      formData.append('alt', this.editData.alt || '');
      formData.append('_method', 'PUT');
      const config = { headers: { 'Content-Type': 'multipart/form-data' } };

      axios
        .post(`/admin/bnrs/${id}`, formData, config)
        .then(response => {
          this.fetchBanners();
          this.$toast.success('Banner updated');
          let updatedItem = response.data.data;
          this.openEditModal(updatedItem);
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
    openEditModal(banner) {
      this.editData.id = banner.id;
      this.editData.url = banner.url || '';
      this.editData.alt = banner.alt || '';
      this.editData.target = banner.target || '';
      this.editData.image = '';
      this.editData.sort_order = banner.sort_order;
      this.editData.image_url = banner.image_url;
      this.editData.image_path = banner.image_path;
    },

    updateStatus(id) {
      topbar.show();
      axios
        .put(`/admin/bnrs/status/${id}`)
        .then(response => {
          this.fetchBanners();
          this.$toast.success('Banner updated');
        })
        .catch(({ response }) => {
          Swal.fire(`Error ${response.status}`, response.statusText, 'error');
        })
        .finally(() => topbar.hide());
    },
    restoreFormControl() {
      this.errors = {};
      this.data.url = '';
      this.data.alt = '';
      this.data.target = '';
      this.data.image = '';
      this.data.sort_order = 1;
      this.imageUrl = '';
    },
    openImage(event) {
      this.data.image = event.target.files[0] || this.data.image;
      this.imageUrl = URL.createObjectURL(this.data.image);
    },
    openImageEdit(event) {
      this.editData.image = event.target.files[0] || this.editData.image;
      this.editData.image_url = URL.createObjectURL(this.editData.image);
    }
  },

  created: function () {
    this.fetchBanners();
  },
  computed: {
    bannerList() {
      return this.banners;
    }
  }
};
</script>
