<template>
  <div class="fw-bolder h2 pb-1 d-flex align-items-center " v-if="item.base_price">
    <span :class="item.has_discount ? 'text-danger' : ''"> {{ price }}</span>
    <s class="mx-2" v-if="item.has_discount">{{ item.view_original_price }}</s>
    <span v-if="item.has_discount" class="badge text-bg-danger user-select-none fs-5">Sale</span>
  </div>
  <div class="py-2 fs-3">
    In Stock: {{ item.in_stock }}
  </div>
  <div class="row border-bottom border-top py-2">
    <div class="col-md-6 d-flex align-items-center mb-3 mb-md-0 justify-content-md-start justify-content-center">
      <div class="d-flex align-items-center">
        <div>
          <button
            type="button"
            class="btn btn-sm btn-primary shadow-none rounded-circle d-flex align-items-center justify-content-center"
            @click="decrement()"
            style="width: 40px; height: 40px"
          >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
            </svg>
          </button>
        </div>
        <div class="h4 px-5 text-center m-0 fw-bold">
          {{ quantity }}
        </div>
        <div>
          <button
            type="button"
            class="btn btn-sm btn-primary shadow-none rounded-circle d-flex align-items-center justify-content-center"
            @click="increment()"
            style="width: 40px; height: 40px"
          >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
          </button>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <button class="btn btn-danger w-100 text-uppercase" type="button" v-on:click="addToCart()">Add to cart</button>
    </div>
  </div>
</template>

<script>
import { usd_money_format } from '@/services/utils';
import { ShoppingCart } from '@/services/shopping-cart';
export default {
  props: ['item'],
  data() {
    return {
      quantity: 1
    };
  },
  created() {},
  methods: {
    addToCart() {
      try {
        ShoppingCart.add(this.item, this.quantity);
        console.log("item:", this.item)
        this.$store.state.cartTotal = ShoppingCart.total();
        this.$store.state.cartTotalItems = ShoppingCart.totalItems();
        this.$toast.show('Added to your cart');
      } catch (ex) {
        console.log(ex.message);
      }
    },
    increment() {
      if (this.item.is_offer) {
        if (this.quantity > parseInt(this.item.in_stock - 1)) {
          return;
        }
      } else {
        if (this.quantity > 100) return;
      }
      this.quantity++;
    },

    decrement() {
      if (this.quantity < 2) return;
      this.quantity--;
    },
    formatNumber(number) {
      return usd_money_format(number, this.currency);
    }
  },
  mounted() {},
  computed: {
    price() {
      return usd_money_format(parseFloat(this.item.base_price) * parseInt(this.quantity));
    }
  }
};
</script>
