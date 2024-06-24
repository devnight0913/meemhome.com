<template>
  <div v-if="cartItems.length > 0">
    <div class="fw-bold h4 mb-2">Your Order</div>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col" class="text-center">image</th>
            <th scope="col">Product Name</th>
            <th scope="col">Quantity</th>
            <th scope="col" class="text-end">Unit Price</th>
            <th scope="col" class="text-end">Total</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cartItem in cartItems" :key="cartItem.slug">
            <td class="text-center">
              <div class="product-img-thumbnail-wrapper text-center">
                <picture>
                  <source type="image/jpg" :data-srcset="cartItem.sm_thumbnail_image_url" />
                  <img :alt="cartItem.name" :data-src="cartItem.sm_thumbnail_image_url" aria-hidden="true" class="product-img-thumbnail lazy" />
                </picture>
              </div>
            </td>
            <td>
              <a :href="cartItem.url" class="link-primary">
                {{ cartItem.name }}
              </a>
            </td>
            <td>
              <div class="d-flex justify-content-center align-items-center">
                <div>
                  <button type="button" class="btn btn-sm btn-primary shadow-none" @click="decrement(cartItem)">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      style="width: 1.25rem; height: 1.25rem"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                    </svg>
                  </button>
                </div>
                <div class="h4 px-5 text-center m-0 fw-bold">
                  {{ cartItem.quantity }}
                </div>
                <div>
                  <button type="button" class="btn btn-sm btn-primary shadow-none" @click="increment(cartItem)">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      style="width: 1.25rem; height: 1.25rem"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                  </button>
                </div>
              </div>
            </td>
            <td class="text-end">{{ cartItem.view_price }}</td>
            <td class="text-end">{{ price(cartItem) }}</td>
            <td class="text-end">
              <button type="button" class="btn btn-sm btn-danger" v-on:click="removeItem(cartItem)">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  style="width: 1.25rem; height: 1.25rem"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                  />
                </svg>
              </button>
            </td>
          </tr>
          <tr>
            <td colspan="4" class="text-end">Total</td>
            <td class="text-end">{{ cartTotal }}</td>
            <td class="text-end"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="d-none d-sm-block">
      <div class="d-flex">
        <a v-if="cartItems.length > 0" href="/order" class="btn btn-lg btn-primary px-4 ms-auto">
          Continue to checkout
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="ms-2"
            style="width: 1.25rem; height: 1.25rem"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
          </svg>
        </a>
      </div>
    </div>
  </div>
  <a
    href="/order"
    class="bottom-0 end-0 position-fixed justify-content-center align-items-center w-100 btn-lg btn btn-primary rounded-0 d-block d-sm-none"
    style="z-index: 1"
    v-if="cartItems.length > 0"
  >
    Continue to checkout
  </a>

  <div v-if="cartItems.length == 0">
    <empty-cart-component></empty-cart-component>
  </div>
</template>
<script>
import EmptyCartComponent from '@/components/EmptyCartComponent';
import { usd_money_format } from '@/services/utils';
import { ShoppingCart } from '@/services/shopping-cart';

export default {
  components: { EmptyCartComponent },
  data() {
    return {
      cartItems: [],
      maxCharecters: 155
    };
  },
  methods: {
    getCartItems() {
      this.cartItems = ShoppingCart.get();
      this.$store.state.cartTotalItems = ShoppingCart.totalItems();
      this.$store.state.cartTotal = ShoppingCart.total();
    },
    removeItem(item) {
      topbar.show();
      ShoppingCart.remove(item);
      this.getCartItems();
      this.$store.state.cartTotalItems = ShoppingCart.totalItems();
      topbar.hide();
    },
    price(cartItem) {
      return usd_money_format(parseFloat(cartItem.base_price) * parseInt(cartItem.quantity));
    },
    increment(cartItem) {
      if (cartItem.is_offer) {
        if (cartItem.quantity > parseInt(cartItem.in_stock - 1)) {
          return;
        }
      }
      ShoppingCart.increment(cartItem);
      this.getCartItems();
    },
    decrement(cartItem) {
      ShoppingCart.decrement(cartItem);
      this.getCartItems();
    }
  },
  created: function () {
    this.getCartItems();
  },
  computed: {
    cartTotal() {
      return usd_money_format(this.$store.state.cartTotal);
    }
  }
};
</script>
