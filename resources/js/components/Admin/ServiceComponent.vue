<template>
  <div class="d-flex align-items-center mb-3">
    <div class="flex-grow-1 h5 fw-bold m-0 ff-montserrat">Services</div>
    <button class="btn btn-primary px-md-4 ms-auto" data-bs-toggle="modal" data-bs-target="#serviceModal">Add Service</button>
  </div>

  <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover mb-0">
        <thead>
          <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Sort Order</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="service in serviceList" :key="service.id">
            <td>
              <img :src="service.image_url" alt="service" class="object-fit-cover rounded-4" style="width: 570px; height: 570px" />
            </td>
            <td>
              <a :href="service.url" class="link-primary" target="_blank">
                {{ service.title }}
              </a>
            </td>
            <td>{{ service.sort_order }}</td>
            <td>
              <div class="form-check form-switch">
                <input
                  class="form-check-input cursor-pointer"
                  type="checkbox"
                  id="flexSwitchCheckChecked"
                  :checked="service.is_active"
                  v-on:change="updateStatus(service.id)"
                />
                <label class="form-check-label" for="flexSwitchCheckChecked">
                  {{ service.status }}
                </label>
              </div>
            </td>
            <td>
              <button class="btn btn-info btn-xs me-md-2" data-bs-toggle="modal" data-bs-target="#editServiceModal" v-on:click="openEditModal(service)">
                Edit
              </button>

              <button class="btn btn-danger btn-xs" v-on:click="deleteService(service.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <NoContent v-if="serviceList.length == 0" />
    </div>
  </div>

  <!-- Modal Create -->
  <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable modal-dialog-centered modal-lg">
      <form @submit.prevent="storeService" class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="serviceModalLabel">Add Service</h5>
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
              style="width: 100%; height: 350px"
            >
              <img
                :src="imageUrl"
                class="rounded-3 object-fit-cover border border-dark"
                alt="placeholder-image"
                style="width: 100%; height: 350px"
                v-if="imageUrl"
              />
              <div class="position-absolute top-50 start-50 translate-middle" v-if="!imageUrl">
                <div class="">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon-xl">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
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
            <label for="title" class="form-label fw-bold">Title</label>
            <input type="text" class="form-control" v-model="data.title" id="title" :class="{ 'is-invalid': errors.hasOwnProperty('title') }" name="title" />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('title')">
              {{ errors.title[0] }}
            </div>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label fw-bold"> Description </label>
            <ckeditor :editor="editor" v-model="data.description" :config="editorConfig"></ckeditor>
            <div class="text-danger" v-if="errors.hasOwnProperty('description')">
              {{ errors.description[0] }}
            </div>
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
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Update -->
  <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable modal-dialog-centered modal-lg">
      <form @submit.prevent="updateService(editData.id)" class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
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
              style="width: 100%; height: 350px"
            >
              <img
                :src="editData.image_url"
                class="rounded-3 object-fit-cover border border-dark"
                alt="placeholder-image"
                style="width: 100%; height: 350px"
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
            <label for="title" class="form-label fw-bold">Title</label>
            <input
              type="text"
              class="form-control"
              v-model="editData.title"
              id="title"
              :class="{ 'is-invalid': errors.hasOwnProperty('title') }"
              name="title"
            />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('title')">
              {{ errors.title[0] }}
            </div>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label fw-bold"> Description </label>
            <ckeditor :editor="editor" v-model="editData.description" :config="editorConfig"></ckeditor>
            <div class="text-danger" v-if="errors.hasOwnProperty('description')">
              {{ errors.description[0] }}
            </div>
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
      services: [],
      pageOfItems: [],
      search: '',
      data: {
        image: '',
        title: '',
        description: '',
        sort_order: 1
      },
      imageUrl: '',
      editData: {
        image_url: '',
        image_path: '',
        image: '',
        title: '',
        description: '',
        sort_order: 1
      },
      errors: {},
      loading: false,
      loadingData: true
    };
  },
  mounted() {},
  methods: {
    fetchServices() {
      topbar.show();
      axios
        .get('/admin/services/all')
        .then(response => (this.services = response.data.data))
        .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
        .finally(() => {
          topbar.hide();
          this.loadingData = false;
        });
    },

    deleteService(id) {
      Swal.fire(swalConfig()).then(result => {
        if (result.value) {
          topbar.show();
          axios
            .delete(`/admin/services/${id}`)
            .then(response => {
              if (response.status == 200) {
                this.fetchServices();
                this.$toast.success('Service deleted');
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
    storeService() {
      this.errors = {};
      topbar.show();
      this.loading = true;
      const formData = new FormData();
      formData.append('image', this.data.image);
      formData.append('sort_order', this.data.sort_order);
      formData.append('title', this.data.title || '');
      formData.append('description', this.data.description || '');

      const config = { headers: { 'Content-Type': 'multipart/form-data' } };
      axios
        .post('/admin/services', formData, config)
        .then(response => {
          this.fetchServices();
          this.restoreFormControl();
          this.$toast.success('Service has been added');
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

    updateService(id) {
      this.errors = {};
      topbar.show();
      this.loading = true;
      const formData = new FormData();
      formData.append('image', this.editData.image);
      formData.append('sort_order', this.editData.sort_order);
      formData.append('title', this.editData.title || '');
      formData.append('description', this.editData.description || '');
      formData.append('_method', 'PUT');
      const config = { headers: { 'Content-Type': 'multipart/form-data' } };

      axios
        .post(`/admin/services/${id}`, formData, config)
        .then(response => {
          this.fetchServices();
          this.$toast.success('Service updated');
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
    openEditModal(service) {
      this.editData.id = service.id;
      this.editData.title = service.title || '';
      this.editData.description = service.description || '';
      this.editData.image = '';
      this.editData.sort_order = service.sort_order;
      this.editData.image_url = service.image_url;
      this.editData.image_path = service.image_path;
    },

    updateStatus(id) {
      topbar.show();
      axios
        .put(`/admin/services/status/${id}`)
        .then(response => {
          this.fetchServices();
          this.$toast.success('Service updated');
        })
        .catch(({ response }) => {
          Swal.fire(`Error ${response.status}`, response.statusText, 'error');
        })
        .finally(() => topbar.hide());
    },
    restoreFormControl() {
      this.errors = {};
      this.data.title = '';
      this.data.description = '';
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
    this.fetchServices();
  },
  computed: {
    serviceList() {
      return this.services;
    }
  }
};
</script>
