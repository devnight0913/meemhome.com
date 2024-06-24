import { createStore } from "vuex";
import { ShoppingCart } from "@/services/shopping-cart";
const store = createStore({
    state() {
        return {
            cartTotal: ShoppingCart.total(),
            cartTotalItems: ShoppingCart.totalItems(),
        };
    },
});

export default store;