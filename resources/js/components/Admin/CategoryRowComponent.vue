<template>
  <div class="d-flex align-items-center py-2">
    <div class="flex-shrink-0 me-2" v-if="category.icon_url">
      <a :href="category.url" target="_blank">
        <picture>
          <source type="image/jpg" :srcset="category.icon_url" />
          <img :alt="category.name" :src="category.icon_url" aria-hidden="true" class="rounded-0 border-0" />
        </picture>
      </a>
    </div>
    <div class="flex-grow-1">
      <a :href="category.url" class="link-primary" target="_blank">
        {{ category.name }}
      </a>
    </div>
  </div>
  <div>
    <span :class="category.is_active ? 'text-bg-primary' : 'text-bg-danger'" class="badge rounded-pill m-2">
      {{ category.status }}
    </span>
    <button class="btn btn-info btn-xs me-2" data-bs-toggle="modal" data-bs-target="#editCategoryModal" @click="handleEditButtonClick">Edit</button>

    <button class="btn btn-danger btn-xs" @click="handleDeleteButtonClick">Delete</button>
  </div>
  <div v-if="category.subcategories">
    <div v-if="category.subcategories.length > 0">
      <small class="text-muted">Subcategories</small>
      <div v-for="subcategory in category.subcategories" :key="subcategory.id">
        <div class="ms-5">
          <CategoryRow :category="subcategory" :editMethod="editMethod" :deleteMethod="deleteMethod" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    category: Object,
    editMethod: '',
    deleteMethod: ''
  },
  data() {
    return {};
  },

  setup(props) {},
  methods: {
    handleEditButtonClick(props) {
      this.editMethod(this.category);
    },
    handleDeleteButtonClick(props) {
      this.deleteMethod(this.category.id);
    }
  },
  created: function () {},
  computed: {}
};
</script>
