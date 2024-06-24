<template>
  <div class="card w-100 rounded-0 shadow border-0">
    <div class="card-body p-4">
      <div v-if="!showInfo">
        <div class="mb-3">
          <div class="h3 fw-bold mb-0">CHECK WARRANTY</div>
          <div class="h5 text-muted mb-0">Review your warranty status and eligibility</div>
        </div>

        <div class="mb-3">
          <label for="serial_number" class="fw-bold">Enter a device serial number</label>

          <div class="mb-3">
            <div class="position-relative">
              <input
                class="form-control rounded-0 text-uppercase"
                v-model="serial_number"
                id="serial_number"
                name="serial_number"
                :class="{ 'border-danger': errors.hasOwnProperty('serial_number') }"
                placeholder="Serial Number"
              />
              <div class="position-absolute top-50 end-0 translate-middle-y p-2">
                <svg
                  @click="openModal"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="hero-icon text-muted cursor-pointer"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"
                  />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                </svg>
              </div>
            </div>
            <div class="text-danger" v-if="errors.hasOwnProperty('serial_number')">
              {{ errors.serial_number[0] }}
            </div>
          </div>
        </div>

        <button type="button" class="btn btn-primary btn-lg px-5 d-flex align-items-center rounded-pill" :disabled="loading" @click="checkWarranty">
          <span v-if="!loading">CHECK</span>

          <div class="d-flex align-items-center align-items-center" v-if="loading">
            <div class="spinner-border spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </button>
      </div>

      <div
        class="modal fade"
        :class="[showModal ? 'show d-block' : 'd-none']"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-fullscreen">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Scan Barcode or QR Code</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal"></button>
            </div>
            <div class="modal-body">
              <StreamBarcodeReader @decode="onDecode" @loaded="onLoaded" v-if="showModal"></StreamBarcodeReader>
            </div>
          </div>
        </div>
      </div>

      <div v-if="showInfo">
        <div class="d-flex align-items-center mb-3" v-if="item">
          <div class="me-2">
            <img :src="item.thumbnail_image_url" :alt="item.name" width="100" height="100" />
          </div>
          <div>
            <h4 class="mb-1">{{ item.name }}</h4>
            <div v-if="item.code">Product Code: {{ item.code }}</div>
            <div>Serial Number: {{ itemSerialNumber }}</div>
            <!-- <div v-if="purchase_date">Purchase Date: {{ purchase_date }}</div> -->
          </div>
        </div>
        <div v-if="is_valid">
          <div class="d-flex align-items-center h4 mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hero-icon-xl text-success me-2">
              <path
                fill-rule="evenodd"
                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                clip-rule="evenodd"
              />
            </svg>
            Your warranty is valid
          </div>
          <div>{{ this.info }}</div>
        </div>

        <div class="d-flex align-items-center h4 mb-0 text-danger" v-if="!is_valid">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hero-icon-xl text-danger me-2">
            <path
              fill-rule="evenodd"
              d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
              clip-rule="evenodd"
            />
          </svg>

          {{ this.info }}
        </div>
        <div v-if="notes">
          <div>{{ notes }}</div>
        </div>

        <div class="text-center mt-3">
          <button type="button" class="btn btn-link" @click="recheck">RECHECK ANOTHER</button>
        </div>
      </div>
      <div class="fw-bold mt-3 text-center">Need Help? <a href="/contact" class="link-primary"> Contact Us</a></div>
    </div>
  </div>
</template>
<script>
import { StreamBarcodeReader } from 'vue-barcode-reader';

export default {
  components: { StreamBarcodeReader },
  props: ['user', 'item'],
  data() {
    return {
      serial_number: '',
      order_number: '',
      purchase_date: '',
      loading: false,
      showInfo: false,
      showModal: false,
      item: null,
      notes: null,
      itemSerialNumber: null,
      info: null,
      is_valid: false,
      errors: {}
    };
  },
  methods: {
    onDecode(text) {
      //alert(text);
      this.showModal = false;
      this.serial_number = text;
      this.checkWarranty();
    },
    onLoaded() {
      //console.log(`Ready to start scanning barcodes`);
    },
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    recheck() {
      this.showInfo = false;
      this.serial_number = '';
      this.item = null;
      this.itemSerialNumber = null;
      this.info = null;
      this.is_valid = null;
      this.errors = {};
    },
    checkWarranty() {
      this.loading = true;
      topbar.show();
      this.errors = {};
      axios
        .post('/warranty/check', {
          serial_number: this.serial_number
        })
        .then(response => {
          this.showInfo = true;
          this.item = response.data.item;
          this.itemSerialNumber = response.data.serial_number;
          this.purchase_date = response.data.purchase_date;
          this.info = response.data.info;
          this.notes = response.data.notes;
          this.is_valid = response.data.is_valid;
        })
        .catch(error => {
          if (error.response.status === 422 || error.response.status === 429) {
            this.errors = error.response.data.errors;
          } else {
            Swal.fire('', 'There was an error posting your review. Please try refreshing the page or try again later', 'error');
          }
        })
        .then(() => {
          topbar.hide();
          this.loading = false;
        });
    }
  }
};
</script>
