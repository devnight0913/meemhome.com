<template>
  <div class="row">
    <div class="col-lg-9 col-md-12">
      <div class="text-uppercase fw-bold h4 mb-3">Complete you order</div>
      <div class="row">
        <div class="col-md-12 mb-3 d-flex align-items-center">
          <span class="badge rounded-pill bg-primary me-2">1</span>
          <span class="text-uppercase fw-bold">Personal Information</span>
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label for="name">Your Name*</label>
            <input
              type="text"
              id="name"
              v-model="data.name"
              class="form-control"
              :class="{
                'is-invalid': errors.hasOwnProperty('name')
              }"
              autocomplete="name"
            />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('name')">
              {{ errors.name[0] }}
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label for="phone">Your Phone Number*</label>
            <div>
              <vue-tel-input
                v-model="data.phone"
                defaultCountry="lb"
                :inputOptions="{ showDialCode: true, styleClasses: 'form-control' }"
                :validCharactersOnly="true"
                :preferredCountries="['lb']"
              ></vue-tel-input>
            </div>
            <div class="form-text">Example: +961 81 203 933</div>
            <div class="text-danger small mt-1" v-if="errors.hasOwnProperty('phone')">
              {{ errors.phone[0] }}
            </div>
          </div>
        </div>
        <div class="col-md-12 mb-3">
          <div class="mb-3">
            <label for="email">Your Email*</label>
            <input
              type="email"
              id="email"
              v-model="data.email"
              class="form-control"
              :class="{
                'is-invalid': errors.hasOwnProperty('email')
              }"
              autocomplete="email"
            />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('email')">
              {{ errors.email[0] }}
            </div>
            <div id="emailHelp" class="form-text" v-if="!errors.hasOwnProperty('email')">You will receive the order details to your email.</div>
          </div>
        </div>
        <div class="col-md-12 mb-3 d-flex align-items-center">
          <span class="badge rounded-pill bg-primary me-2">2</span>
          <span class="text-uppercase fw-bold">Order Details</span>
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label for="delivery" class="form-label fw-bold">Order Type*</label>
            <select
              id="delivery"
              v-model="data.delivery"
              class="form-select cursor-pointer shadow-sm"
              :class="{
                'is-invalid': errors.hasOwnProperty('delivery')
              }"
              aria-label="Tipo de pedido*"
              @change="selectChange"
            >
              <option v-bind:value="true" selected>Delivery</option>
              <option v-bind:value="false">Pickup</option>
            </select>
            <div class="text-danger" v-if="errors.hasOwnProperty('delivery')">
              {{ errors.delivery[0] }}
            </div>
          </div>
        </div>
        <div class="col-md-12" :class="{ 'd-none': isDelivery }">
          <div class="card shadow-sm mb-3">
            <div class="card-body">
              <div class="mb-2">
                <a :href="link" class="link-primary" target="_blank">
                  <img src="/images/webp/pin-24x24.webp" alt="pin" />
                  {{ address }}
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12" :class="{ 'd-none': !isDelivery }">
          <div class="card-title fs-5 fw-bold">Delivery Address</div>

          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <Dropdown
                  v-model="data.area"
                  :options="areas"
                  optionLabel="name"
                  optionValue="id"
                  placeholder="Select your area*"
                  :filter="true"
                  filterPlaceholder="Search..."
                  emptyFilterMessage="No results found"
                  emptyMessage="No results found"
                  :loading="loadingAreas"
                />

                <div class="text-danger" v-if="errors.hasOwnProperty('area')">
                  {{ errors.area[0] }}
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <textarea
                  id="address"
                  v-model="data.address"
                  class="form-control"
                  :class="{
                    'is-invalid': errors.hasOwnProperty('address')
                  }"
                  placeholder="Address*"
                  aria-label="Address*"
                  autocomplete="address"
                  rows="3"
                >
                </textarea>
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('address')">
                  {{ errors.address[0] }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="mb-3">
            <label for="payment_method" class="form-label fw-bold">Payment Method*</label>
            <Dropdown
              v-model="data.payment_method"
              :options="paymentMethodsList"
              optionLabel="name"
              optionValue="id"
              placeholder="Payment Method*"
              emptyFilterMessage="No results found"
              emptyMessage="No results found"
              :loading="loadingPaymentMethods"
            />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('payment_method')">
              {{ errors.payment_method[0] }}
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <textarea
              id="comment"
              v-model="data.comment"
              class="form-control shadow-sm"
              :class="{
                'is-invalid': errors.hasOwnProperty('comment')
              }"
              placeholder="Comments on the order"
              aria-label="Comments on the order"
              autocomplete="comment"
            ></textarea>
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('comment')">
              {{ errors.comment[0] }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-12">
      <div>
        <span class="text-muted">Subltotal:</span>
        <div class="text-muted">
          {{ showSubtotal }}
        </div>
      </div>
      <hr />
      <div v-if="couponDiscountPrice > 0">
        <span class="text-muted">Discount:</span>
        <div class="text-muted">
          {{ showDiscount }}
        </div>
        <hr />
      </div>

      <template v-if="isDelivery">
        <div>
          <span class="text-muted">Delivery Charge:</span>
          <div class="text-muted">
            {{ showDeliveryFee }}
          </div>
        </div>
        <hr />
        <div>
          <span class="text-muted">Delivery Time:</span>
          <div class="text-muted">{{ deliveryTime }}</div>
        </div>
        <hr />
      </template>
      <div>
        <span class="fw-bold">Total:</span>
        <div class="fw-bold">
          {{ showTotal }}
        </div>
      </div>

      <template v-if="couponAdded">
        <hr />
        <div>
          Coupon: <span class="text-muted">{{ data.coupon_code }}</span>
        </div>
        <div v-if="coupon.description">
          {{ coupon.description }}
        </div>
      </template>

      <button
        v-if="!couponAdded"
        class="btn btn-danger w-100 my-3"
        type="button"
        id="coupon-add-btn"
        data-bs-toggle="modal"
        data-bs-target="#CouponModal"
        :disabled="couponAdded"
      >
        Apply Coupon
      </button>
    </div>
    <div class="col-lg-9 col-sm-12 text-center">
      <button type="submit" class="btn btn-primary btn-lg px-5 w-100" :disabled="loading" @click="storeOrder">
        Submit Order

        <div class="spinner-border spinner-border-sm text-light ms-1" role="status" v-if="loading">
          <span class="visually-hidden">Loading...</span>
        </div>
      </button>
    </div>
  </div>
  <!-- Coupn Modal -->
  <div class="modal fade" id="CouponModal" tabindex="-1" aria-labelledby="CouponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-bottom-0">
          <h5 class="modal-title" id="CouponModalLabel">
            <i class="fa-solid fa-ticket me-1 fa-lg"></i>
            Apply Coupon
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <input
              type="text"
              id="coupon_code"
              v-model="data.coupon_code"
              :disabled="couponAdded"
              class="form-control"
              :class="{
                'is-invalid': errors.hasOwnProperty('coupon_code'),
                'is-valid': couponAdded
              }"
              placeholder="Coupon Code"
              aria-label="Coupon Code"
              autocomplete="coupon_code"
            />
            <div class="invalid-feedback" v-if="errors.hasOwnProperty('coupon_code')">
              {{ errors.coupon_code[0] }}
            </div>
            <div class="valid-feedback" v-if="couponAdded">Coupon is valid</div>
          </div>
          <button class="btn btn-primary w-100" :disabled="data.coupon_code.length == 0 || couponAdded" @click="addCoupon">Apply</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { usd_money_format } from '@/services/utils';
import { ShoppingCart } from '@/services/shopping-cart';
const SOURCE_WEBSITE = 1;
export default {
  props: ['user', 'address', 'link'],
  data() {
    return {
      areas: [],
      payment_methods: [],
      data: {
        user_id: this.user.id || '',
        name: this.user.name || '',
        phone: this.user.contact_phone || '',
        email: this.user.email || '',
        delivery: true,

        area: this.user.area_id || '',
        address: this.user.address || '',

        payment_method: 0,
        coupon_code: '',
        comment: '',
        cart: {
          items: ShoppingCart.get(),
          total: ShoppingCart.total()
        },
        source: SOURCE_WEBSITE
      },
      isDelivery: 1,
      couponAdded: false,
      couponDiscount: 0,
      coupon: '',
      loading: false,
      loadingAreas: false,
      loadingPaymentMethods: false,
      errors: {}
    };
  },
  methods: {
    storeOrder() {
      if (ShoppingCart.isEmpty()) {
        Swal.fire('Your bag is empty!!', '', 'warning').then(function () {
          window.location = '/cart';
        });
      }

      this.loading = true;
      topbar.show();
      this.errors = {};

      axios
        .post('/api/v1/order', this.data)
        .then(response => {
          Swal.fire('Your order has been submitted successfully', 'Thank you for choosing us!', 'success').then(function () {
            ShoppingCart.clear();
            window.location = '/';
          });
        })
        .catch(error => {
          if (error.response.status === 422 || error.response.status === 429) {
            this.errors = error.response.data.errors;
            Swal.fire('Please fill out all required fields.', error.response.data.message, 'error')
          } else {
            Swal.fire('', 'There was an error submitting your order. Please try refreshing the page or try again later', 'error');
          }
        })
        .then(() => {
          topbar.hide();
          this.loading = false;
        });
    },

    fetchAreas() {
      this.loadingAreas = true;
      axios
        .get('/api/v1/areas')
        .then(response => {
          this.areas = response.data.data;
        })
        .catch(error => {})
        .then(() => {
          this.loadingAreas = false;
        });
    },
    fetchPaymentMethods() {
      this.loadingPaymentMethods = true;
      axios
        .get('/api/v1/payment-methods')
        .then(response => {
          this.payment_methods = response.data.data;
          this.data.payment_method = this.paymentMethodsList[0].id;
        })
        .catch(error => {})
        .then(() => {
          this.loadingPaymentMethods = false;
        });
    },
    selectChange() {
      this.isDelivery = this.data.delivery;
      this.data.payment_method = this.paymentMethodsList[0].id;
      this.couponDiscount = 0;
      this.couponAdded = false;
    },
    addCoupon() {
      topbar.show();
      this.errors = {};
      let requestData = {
        coupon_code: this.data.coupon_code
      };
      axios
        .post('/api/v1/coupon', requestData)
        .then(response => {
          this.coupon = response.data.data;
          this.couponDiscount = (this.$store.state.cartTotal * this.coupon.percentage) / 100;

          this.couponAdded = true;
        })
        .catch(error => {
          this.errors = { coupon_code: ['Coupon invalid'] };
        })
        .then(() => {
          topbar.hide();
        });
    },
    currencyFormat(number) {
      return usd_money_format(parseFloat(number));
    }
  },
  created: function () {
    this.fetchAreas();
    this.fetchPaymentMethods();
  },
  mounted() {
    if (ShoppingCart.totalItems() == 0) {
      window.location = '/cart';
    }
  },
  computed: {
    orderSubtotal() {
      return this.$store.state.cartTotal;
    },
    orderTotal() {
      return this.isDelivery ? this.deliveryFee + this.orderSubtotal - this.couponDiscount : this.orderSubtotal - this.couponDiscount;
    },
    deliveryFee() {
      let deliveryArea = this.areas.find(area => area.id === this.data.area);
      return deliveryArea ? deliveryArea.fee : 0;
    },
    isAreaSelected() {
      return !!this.data.area;
    },
    deliveryTime() {
      let deliveryArea = this.areas.find(area => area.id === this.data.area);
      return deliveryArea ? deliveryArea.view_time : '0 min';
    },
    isDisable(input) {
      return input.length > 0;
    },
    couponDiscountPrice() {
      return this.couponDiscount;
    },
    paymentMethodsList() {
      return this.payment_methods;
    },
    showSubtotal() {
      return this.currencyFormat(this.orderSubtotal);
    },
    showDiscount() {
      return this.currencyFormat(this.couponDiscountPrice);
    },
    showTotal() {
      return this.currencyFormat(this.orderTotal);
    },
    showDeliveryFee() {
      return this.currencyFormat(this.deliveryFee);
    }
  }
};
</script>
