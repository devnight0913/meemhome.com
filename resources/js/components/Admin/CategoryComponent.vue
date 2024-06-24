<template>
  <div class="d-flex align-items-center mb-3">
    <div class="flex-grow-1 h5 fw-bold m-0 ff-montserrat">Categories</div>
    <button class="btn btn-primary ms-auto px-md-4" data-bs-toggle="modal" data-bs-target="#categoryModal">Add Category</button>
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
    <div class="border-bottom py-2" v-for="category in categoryList" :key="category.id">
      <CategoryRow :category="category" :editMethod="openEditModal" :deleteMethod="deleteCategory" />
    </div>
    <NoContent v-if="categoryList.length == 0" />
  </div>

  <!-- Modal Create -->
  <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-lg modal-dialog-scrollable">
      <form @submit.prevent="storeCategory" class="modal-content rounded-4">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="methodModalLabel">Add Category</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal" @click="restoreFormControl()">Discard</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>
        <div class="modal-body bg-body">
          <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="text-center">
              <label
                for="input-image"
                class="cursor-pointer position-relative rounded-3"
                :class="{
                  'border border-dark': !imageUrl
                }"
                style="width: 160px; height: 160px"
              >
                <img
                  :src="imageUrl"
                  class="border border-dark rounded-3"
                  alt="placeholder-image"
                  v-if="imageUrl"
                  style="width: 160px; height: 160px; object-fit: contain"
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
          </div>

          <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="text-center">
              <label
                for="input-cover-image"
                class="cursor-pointer position-relative rounded-3 w-100"
                :class="{
                  'border border-dark': !coverImageUrl
                }"
                :style="{ height: coverImageUrl ? 'auto' : '160px' }"
              >
                <img :src="coverImageUrl" class="w-100 h-auto border border-dark rounded-3" alt="placeholder-image" v-if="coverImageUrl" />
                <div class="position-absolute top-50 start-50 translate-middle" v-if="!coverImageUrl">
                  <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 96 960 960" width="48">
                      <path
                        d="M180 936q-24.75 0-42.375-17.625T120 876V276q0-24.75 17.625-42.375T180 216h409v60H180v600h600V468h60v408q0 24.75-17.625 42.375T780 936H180Zm520-498v-81h-81v-60h81v-81h60v81h81v60h-81v81h-60ZM240 774h480L576 582 449 749l-94-124-115 149Zm-60-498v600-600Z"
                      />
                    </svg>
                  </div>
                  <div class="fw-bold">Choose Cover Image</div>
                </div>
              </label>

              <div class="text-danger" v-if="errors.hasOwnProperty('cover_image')">
                {{ errors.cover_image[0] }}
              </div>
              <input
                id="input-cover-image"
                class="d-none"
                type="file"
                name="input-cover-image"
                accept="image/x-png, image/jpeg, image/jpg"
                value=""
                @change="openCoverImage"
              />
            </div>
          </div>

          <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="mb-3">
              <label for="status_id" class="form-label fw-bold">Category Status </label>
              <select
                class="form-select"
                v-model="data.status_id"
                id="status_id"
                :class="{ 'is-invalid': errors.hasOwnProperty('status_id') }"
                name="status_id"
              >
                <option value="1">Active</option>
                <option value="2">Drafted</option>
              </select>
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('status_id')">
                {{ errors.status_id[0] }}
              </div>
              <div v-if="data.status_id == 1" class="form-text">This category will be available to checked sales channels</div>
              <div v-if="data.status_id == 2" class="form-text">This category will be <span class="fw-bold">hidden</span> from all sales channels</div>
            </div>
            <div class="d-none">
              <label class="form-label fw-bold">Sales Channels and APPS </label>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="data.pos" id="posCheckbox" />
                <label class="form-check-label" for="posCheckbox"> Point of Sale </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="data.website" id="websiteCheckbox" />
                <label class="form-check-label" for="websiteCheckbox"> Website </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="data.android_app" id="androidCheckbox" />
                <label class="form-check-label" for="androidCheckbox"> Android APP </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="data.ios_app" id="iosCheckbox" />
                <label class="form-check-label" for="iosCheckbox"> IOS APP </label>
              </div>
            </div>
          </div>
          <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="mb-3">
              <label for="name" class="form-label fw-bold">Category Name</label>
              <input type="text" class="form-control" v-model="data.name" id="name" :class="{ 'is-invalid': errors.hasOwnProperty('name') }" name="name" />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('name')">
                {{ errors.name[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label for="sort-order" class="form-label fw-bold"> Sort Order </label>
              <input
                type="number"
                class="form-control"
                v-model="data.sort_order"
                step="1"
                min="1"
                id="sort-order"
                :class="{ 'is-invalid': errors.hasOwnProperty('sort_order') }"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('sort_order')">
                {{ errors.sort_order[0] }}
              </div>
            </div>
            <div>
              <label for="parent" class="form-label fw-bold">Parent Category</label>
              <Dropdown
                v-model="data.parentCategory"
                :options="categories"
                placeholder="Select Parent Category*"
                :filter="false"
                filterPlaceholder="Search..."
                emptyFilterMessage="No results found"
                emptyMessage="No results found"
              >
                <template #value="slotProps">
                  <div class="d-flex align-items-center" v-if="slotProps.value">
                    <img
                      :alt="slotProps.value.name"
                      :src="slotProps.value.select_icon_url"
                      height="40"
                      class="me-2"
                      :class="{ border: !slotProps.value.image_path }"
                    />
                    <span>{{ slotProps.value.name }}</span>
                  </div>
                </template>
                <template #option="slotProps">
                  <div class="d-flex align-items-center">
                    <img
                      :alt="slotProps.option.name"
                      :src="slotProps.option.select_icon_url"
                      height="40"
                      class="me-2"
                      :class="{ border: !slotProps.option.image_path }"
                    />
                    <span>{{ slotProps.option.name }}</span>
                  </div>
                </template>
              </Dropdown>
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('parent_id')">
                {{ errors.parent_id[0] }}
              </div>
            </div>
          </div>
          <div class="border rounded-3 p-3 bg-white border-light shadow-sm">
            <div class="form-label fw-bold mb-3">Search engine listing preview</div>
            <div class="mb-3">
              <div class="seo-url">{{ `${app_url}/p/product` }}</div>
              <div class="seo-title">{{ data.meta_title || data.name.substring(0, 69) + '...' }}</div>
              <div class="small text-muted">{{ data.meta_description }}</div>
            </div>
            <div class="mb-3">
              <label for="meta_title" class="form-label fw-bold">Page Title</label>
              <input
                type="text"
                class="form-control"
                v-model="data.meta_title"
                id="meta_title"
                :class="{ 'is-invalid': errors.hasOwnProperty('meta_title') }"
                name="meta_title"
                maxlength="70"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('meta_title')">
                {{ errors.meta_title[0] }}
              </div>
              <div class="form-text">Max 70 Characters</div>
            </div>
            <div class="mb-3">
              <label for="meta_description" class="form-label fw-bold">Description</label>
              <textarea
                class="form-control"
                v-model="data.meta_description"
                id="meta_description"
                :class="{ 'is-invalid': errors.hasOwnProperty('meta_description') }"
                maxlength="320"
                name="meta_description"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('meta_description')">
                {{ errors.meta_description[0] }}
              </div>
              <div class="form-text">Max 320 Characters</div>
            </div>
            <div>
              <label for="keywords" class="form-label fw-bold">Search Keywords</label>
              <input
                type="text"
                class="form-control"
                v-model="data.keywords"
                id="keywords"
                :class="{ 'is-invalid': errors.hasOwnProperty('keywords') }"
                name="keywords"
                maxlength="70"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('keywords')">
                {{ errors.keywords[0] }}
              </div>
              <div class="form-text">Max 160 Characters, separated by comma</div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- MODAL EDIT -->
  <div class="modal" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-lg modal-dialog-scrollable">
      <form @submit.prevent="updateCategory(editData.id)" class="modal-content rounded-4">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>
        <div class="modal-body bg-body">
          <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
            <div
              class="text-center"
              :class="{
                ' mb-3': editData.image_path
              }"
            >
              <label
                for="input-image-edit"
                class="cursor-pointer position-relative rounded-3"
                :class="{
                  'border border-dark': !editData.image_url
                }"
                style="width: 160px; height: 160px"
              >
                <img
                  :src="editData.image_url"
                  class="border border-dark rounded-3"
                  alt="placeholder-image"
                  v-if="editData.image_url"
                  style="width: 160px; height: 160px; object-fit: contain"
                />
                <div class="position-absolute top-50 start-50 translate-middle" v-if="!editData.image_url">
                  <div class="">
                    <MtIcon icon="add_photo_alternate" styleName="fs-1"></MtIcon>
                  </div>
                  <div class="fw-bold">Choose Image</div>
                </div>
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
            <div class="d-flex align-items-center justify-content-center">
              <button type="button" class="btn btn-sm btn-outline-danger px-4" @click="deleteImage" v-if="this.editData.image_path">Delete Image</button>
            </div>
          </div>

          <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
            <div
              class="text-center"
              :class="{
                ' mb-3': editData.cover_image_path
              }"
            >
              <label
                for="input-cover-image-edit"
                class="cursor-pointer position-relative rounded-3 w-100"
                :class="{
                  'border border-dark': !editData.cover_image_url
                }"
                :style="{ height: editData.cover_image_url ? 'auto' : '160px' }"
              >
                <img
                  :src="editData.cover_image_url"
                  class="w-100 h-auto border border-dark rounded-3"
                  alt="placeholder-image"
                  v-if="editData.cover_image_url"
                />
                <div class="position-absolute top-50 start-50 translate-middle" v-if="!editData.cover_image_url">
                  <div class="">
                    <MtIcon icon="add_photo_alternate" styleName="fs-1"></MtIcon>
                  </div>
                  <div class="fw-bold">Choose Cover Image</div>
                </div>
              </label>

              <div class="text-danger" v-if="errors.hasOwnProperty('cover_image')">
                {{ errors.cover_image[0] }}
              </div>
              <input
                id="input-cover-image-edit"
                class="d-none"
                type="file"
                name="input-cover-image-edit"
                accept="image/x-png, image/jpeg, image/jpg"
                value=""
                @change="openCoverImageEdit"
              />
            </div>
            <div class="d-flex align-items-center justify-content-center">
              <button type="button" class="btn btn-sm btn-outline-danger px-4" @click="deleteCoverImage" v-if="this.editData.cover_image_path">
                Delete Cover Image
              </button>
            </div>
          </div>

          <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="mb-3">
              <label for="edit_status_id" class="form-label fw-bold">Category Status </label>
              <select
                class="form-select"
                v-model="editData.status_id"
                id="edit_status_id"
                :class="{ 'is-invalid': errors.hasOwnProperty('status_id') }"
                name="edit_status_id"
              >
                <option value="1">Active</option>
                <option value="2">Drafted</option>
              </select>
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('status_id')">
                {{ errors.status_id[0] }}
              </div>
              <div v-if="editData.status_id == 1" class="form-text">This category will be available to checked sales channels</div>
              <div v-if="editData.status_id == 2" class="form-text">This category will be <span class="fw-bold">hidden</span> from all sales channels</div>
            </div>
            <div class="d-none">
              <label class="form-label fw-bold">Sales Channels and APPS </label>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="editData.pos" id="posEditCheckbox" />
                <label class="form-check-label" for="posEditCheckbox"> Point of Sale </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="editData.website" id="websiteEditCheckbox" />
                <label class="form-check-label" for="websiteEditCheckbox"> Website </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="editData.android_app" id="androidEditCheckbox" />
                <label class="form-check-label" for="androidEditCheckbox"> Android APP </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="editData.ios_app" id="iosEditCheckbox" />
                <label class="form-check-label" for="iosEditCheckbox"> IOS APP </label>
              </div>
            </div>
          </div>

          <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="mb-3">
              <label for="name" class="form-label fw-bold">Category Name</label>
              <input type="text" class="form-control" v-model="editData.name" id="name" :class="{ 'is-invalid': errors.hasOwnProperty('name') }" name="name" />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('name')">
                {{ errors.name[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label for="sort-order-edit" class="form-label fw-bold"> Sort Order </label>
              <input
                type="number"
                class="form-control"
                v-model="editData.sort_order"
                step="1"
                min="1"
                id="sort-order-edit"
                :class="{ 'is-invalid': errors.hasOwnProperty('sort_order') }"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('sort_order')">
                {{ errors.sort_order[0] }}
              </div>
            </div>
            <div>
              <label for="parent" class="form-label fw-bold">Parent Category</label>
              <Dropdown
                v-model="editData.parentCategory"
                :options="categories"
                placeholder="Select Parent Category*"
                :filter="false"
                filterPlaceholder="Search..."
                emptyFilterMessage="No results found"
                emptyMessage="No results found"
              >
                <template #value="slotProps">
                  <div class="d-flex align-items-center" v-if="slotProps.value">
                    <img
                      :alt="slotProps.value.name"
                      :src="slotProps.value.select_icon_url"
                      height="40"
                      class="me-2"
                      :class="{ border: !slotProps.value.image_path }"
                    />
                    <span>{{ slotProps.value.name }}</span>
                  </div>
                </template>
                <template #option="slotProps">
                  <div class="d-flex align-items-center">
                    <img
                      :alt="slotProps.option.name"
                      :src="slotProps.option.select_icon_url"
                      height="40"
                      class="me-2"
                      :class="{ border: !slotProps.option.image_path }"
                    />
                    <span>{{ slotProps.option.name }}</span>
                  </div>
                </template>
              </Dropdown>
              <div class="text-danger" v-if="errors.hasOwnProperty('parent_id')">
                {{ errors.parent_id[0] }}
              </div>
            </div>
            <div v-if="editData.parentCategory" class="my-3 text-center">
              <button type="button" class="btn btn-link text-danger fw-bold" @click="removeParentCategory">Remove Parent Category</button>
            </div>
          </div>

          <div class="border rounded-3 p-3 bg-white border-light shadow-sm">
            <div class="form-label fw-bold mb-3">Search engine listing preview</div>
            <div class="mb-3">
              <div class="seo-url">{{ `${app_url}/p/product` }}</div>
              <div class="seo-title">{{ editData.meta_title || editData.name.substring(0, 69) + '...' }}</div>
              <div class="small text-muted">{{ editData.meta_description }}</div>
            </div>
            <div class="mb-3">
              <label for="meta_title_edit" class="form-label fw-bold">Page Title</label>
              <input
                type="text"
                class="form-control"
                v-model="editData.meta_title"
                id="meta_title_edit"
                :class="{ 'is-invalid': errors.hasOwnProperty('meta_title') }"
                name="meta_title_edit"
                maxlength="70"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('meta_title')">
                {{ errors.meta_title[0] }}
              </div>
              <div class="form-text">Max 70 Characters</div>
            </div>
            <div class="mb-3">
              <label for="meta_description_edit" class="form-label fw-bold">Description</label>
              <textarea
                class="form-control"
                v-model="editData.meta_description"
                id="meta_description_edit"
                :class="{ 'is-invalid': errors.hasOwnProperty('meta_description') }"
                maxlength="320"
                name="meta_description_edit"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('meta_description')">
                {{ errors.meta_description[0] }}
              </div>
              <div class="form-text">Max 320 Characters</div>
            </div>
            <div>
              <label for="keywords_edit" class="form-label fw-bold">Search Keywords</label>
              <input
                type="text"
                class="form-control"
                v-model="editData.keywords"
                id="keywords_edit"
                :class="{ 'is-invalid': errors.hasOwnProperty('keywords') }"
                name="keywords_edit"
                maxlength="70"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('keywords')">
                {{ errors.keywords[0] }}
              </div>
              <div class="form-text">Max 160 Characters, separated by comma</div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { swalConfig } from '@/services/utils';
import config from '@/config';
export default {
  data() {
    return {
      parentsCategories: [],
      categories: [],
      app_url: config.APP_URL,
      search: '',
      imageUrl: '',
      coverImageUrl: '',
      data: {
        name: '',
        image: '',
        cover_image: '',
        sort_order: 1,
        status_id: 1,
        meta_title: '',
        meta_description: '',
        keywords: '',
        parentCategory: null,
        pos: true,
        website: true,
        android_app: true,
        ios_app: true
      },
      editData: {
        id: '',
        name: '',
        image: '',
        cover_image: '',
        image_url: '',
        image_path: '',
        cover_image_url: '',
        cover_image_path: '',
        sort_order: 1,
        status_id: 1,
        meta_title: '',
        meta_description: '',
        keywords: '',
        parentCategory: null,
        pos: true,
        website: true,
        android_app: true,
        ios_app: true
      },
      errors: {},
      loading: false
    };
  },
  mounted() {},
  methods: {
    fetchParentCategories() {
      topbar.show();
      axios
        .get('/admin/categories/parents/all')
        .then(response => (this.parentsCategories = response.data.data))
        .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
        .then(() => topbar.hide());
    },
    fetchCategories() {
      topbar.show();
      axios
        .get('/admin/categories/all')
        .then(response => (this.categories = response.data.data))
        .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
        .then(() => topbar.hide());
    },
    refreshTable() {
      this.fetchCategories();
      this.fetchParentCategories();
    },
    updateCategory(id) {
      this.errors = {};
      topbar.show();
      this.loading = true;

      const formData = new FormData();
      formData.append('image', this.editData.image);
      formData.append('cover_image', this.editData.cover_image);
      formData.append('name', this.editData.name);
      formData.append('sort_order', this.editData.sort_order);
      formData.append('status', this.editData.status_id);
      formData.append('meta_title', this.editData.meta_title || '');
      formData.append('meta_description', this.editData.meta_description || '');
      formData.append('keywords', this.editData.keywords || '');
      formData.append('parent_id', this.editData.parentCategory ? this.editData.parentCategory.id : '');
      if (this.editData.pos) {
        formData.append('pos', this.editData.pos);
      }
      if (this.editData.website) {
        formData.append('website', this.editData.website);
      }

      if (this.editData.android_app) {
        formData.append('android_app', this.editData.android_app);
      }
      if (this.editData.ios_app) {
        formData.append('ios_app', this.editData.ios_app);
      }
      formData.append('_method', 'PUT');
      const config = { headers: { 'Content-Type': 'multipart/form-data' } };

      axios
        .post(`/admin/categories/${id}`, formData, config)
        .then(response => {
          this.fetchCategories();
          this.fetchParentCategories();
          this.$toast.success('Category has been updated');
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

    removeParentCategory: function () {
      this.editData.parentCategory = null;
      // axios
      //   .put(`/admin/categories/${this.editData.id}/parents/destroy`)
      //   .then(response => {

      //     this.fetchCategories();
      //     this.fetchParentCategories();
      //     this.$toast.success('Category has been updated');
      //   })
      //   .catch(({ response }) => {
      //     if (response.status === 422 || response.status === 429) {
      //       this.errors = response.data.errors;
      //     } else {
      //       Swal.fire(`Error ${response.status}`, response.statusText, 'error');
      //     }
      //   })
      //   .then(() => {
      //     topbar.hide();
      //     this.loading = false;
      //   });
    },

    openImageEdit(event) {
      var file = event.target.files[0];
      if (file) {
        this.editData.image = file;
        this.editData.image_url = URL.createObjectURL(this.editData.image);
      } else {
        this.editData.image = this.editData.image;
        this.editData.image_url = this.editData.image_url;
      }
    },
    openCoverImageEdit(event) {
      var file = event.target.files[0];
      if (file) {
        this.editData.cover_image = file;
        this.editData.cover_image_url = URL.createObjectURL(this.editData.cover_image);
      } else {
        this.editData.cover_image = this.editData.cover_image;
        this.editData.cover_image_url = this.editData.cover_image_url;
      }
    },
    deleteCategory(id) {
      Swal.fire(swalConfig()).then(result => {
        if (result.value) {
          topbar.show();
          axios
            .delete(`/admin/categories/${id}`)
            .then(response => {
              if (response.status == 200) {
                this.fetchCategories();
                this.fetchParentCategories();
                //this.categories = this.categories.filter(category => category.id != id);
                this.$toast.success('Category has been deleted');
              }
            })
            .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
            .then(() => topbar.hide());
        }
      });
    },
    openEditModal: function (category) {
      this.editData.id = category.id;
      this.editData.name = category.name;
      this.editData.sort_order = category.sort_order;
      this.editData.meta_title = category.meta_title;
      this.editData.meta_description = category.meta_description;
      this.editData.keywords = category.keywords;
      this.editData.pos = category.pos;
      this.editData.website = category.website;
      this.editData.android_app = category.android_app;
      this.editData.ios_app = category.ios_app;
      this.editData.status_id = category.status_id;
      this.editData.parentCategory = this.categories.find(c => c.id == category.parent_id) || null;

      this.editData.image = '';
      this.editData.cover_image = '';
      if (category.image_path) {
        this.editData.image_url = category.image_url;
        this.editData.image_path = category.image_path;
      } else {
        this.editData.image_url = null;
        this.editData.image_path = null;
      }

      if (category.cover_image_path) {
        this.editData.cover_image_url = category.cover_image_url;
        this.editData.cover_image_path = category.cover_image_path;
      } else {
        this.editData.cover_image_url = null;
        this.editData.cover_image_path = null;
      }
    },
    deleteImage() {
      Swal.fire(swalConfig()).then(result => {
        if (result.value) {
          topbar.show();
          axios
            .delete(`/admin/categories/image/${this.editData.id}`)
            .then(response => {
              if (response.status == 200) {
                this.editData.image = '';
                this.editData.image_url = null;
                this.editData.image_path = null;
                var categoryToUpdate = this.categories.find(category => category.id == this.editData.id);
                if (categoryToUpdate) {
                  categoryToUpdate.image = '';
                  categoryToUpdate.image_url = null;
                  categoryToUpdate.image_path = null;
                  categoryToUpdate.icon_url = null;
                }
                this.$toast.success('Image has been deleted');
              }
            })
            .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
            .then(() => topbar.hide());
        }
      });
    },
    deleteCoverImage() {
      Swal.fire(swalConfig()).then(result => {
        if (result.value) {
          topbar.show();
          axios
            .delete(`/admin/categories/cover-image/${this.editData.id}`)
            .then(response => {
              if (response.status == 200) {
                this.editData.cover_image = '';
                this.editData.cover_image_url = null;
                this.editData.cover_image_path = null;
                var categoryToUpdate = this.categories.find(category => category.id == this.editData.id);
                if (categoryToUpdate) {
                  categoryToUpdate.cover_image = '';
                  categoryToUpdate.cover_image_url = null;
                  categoryToUpdate.cover_image_path = null;
                }
                this.$toast.success('Cover image has been deleted');
              }
            })
            .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
            .then(() => topbar.hide());
        }
      });
    },

    storeCategory() {
      this.errors = {};
      topbar.show();
      this.loading = true;

      const formData = new FormData();
      formData.append('image', this.data.image);
      formData.append('cover_image', this.data.cover_image);
      formData.append('name', this.data.name);
      formData.append('sort_order', this.data.sort_order);
      formData.append('status', this.data.status_id);
      formData.append('meta_title', this.data.meta_title || '');
      formData.append('meta_description', this.data.meta_description || '');
      formData.append('keywords', this.data.keywords || '');
      formData.append('parent_id', this.data.parentCategory ? this.data.parentCategory.id : '');
      if (this.data.pos) {
        formData.append('pos', this.data.pos);
      }
      if (this.data.website) {
        formData.append('website', this.data.website);
      }

      if (this.data.android_app) {
        formData.append('android_app', this.data.android_app);
      }
      if (this.data.ios_app) {
        formData.append('ios_app', this.data.ios_app);
      }
      const config = { headers: { 'Content-Type': 'multipart/form-data' } };

      axios
        .post('/admin/categories', formData, config)
        .then(response => {
          this.fetchCategories();
          this.fetchParentCategories();
          this.restoreFormControl();
          this.$toast.success('New category added');
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

    openImage(event) {
      var file = event.target.files[0];
      if (file) {
        this.data.image = file;
        this.imageUrl = URL.createObjectURL(this.data.image);
      } else {
        this.data.image = this.data.image;
        this.imageUrl = this.imageUrl;
      }
    },

    openCoverImage(event) {
      var file = event.target.files[0];
      if (file) {
        this.data.cover_image = file;
        this.coverImageUrl = URL.createObjectURL(this.data.cover_image);
      } else {
        this.data.cover_image = this.data.cover_image;
        this.coverImageUrl = this.coverImageUrl;
      }
    },

    updateStatus(id) {
      topbar.show();
      axios
        .put(`/admin/categories/status/${id}`)
        .then(response => {
          this.fetchCategories();
          this.fetchParentCategories();
          this.$toast.success('Category has been updated');
        })
        .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
        .then(() => topbar.hide());
    },
    restoreFormControl() {
      this.errors = {};
      this.data.name = '';
      this.data.image = '';
      this.data.cover_image = '';
      this.data.sort_order = 1;
      this.data.status_id = 1;
      this.data.meta_title = '';
      this.data.meta_description = '';
      this.data.keywords = '';
      this.data.parentCategory = null;
      this.data.pos = true;
      this.data.website = true;
      this.data.android_app = true;
      this.data.ios_app = true;
      this.imageUrl = '';
      this.coverImageUrl = '';
    }
  },

  created: function () {
    this.fetchCategories();
    this.fetchParentCategories();
  },
  computed: {
    categoryList() {
      const search = this.search.toLowerCase();
      if (!search) return this.parentsCategories;
      return this.parentsCategories.filter(category => {
        return category.name.toLowerCase().includes(search);
      });
    }
  }
};
</script>
