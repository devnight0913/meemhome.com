import { encrypt, decrypt } from '@/services/utils';

export const ShoppingCart = {
  add,
  remove,
  get,
  cartExists,
  total,
  totalItems,
  isEmpty,
  clear,
  increment,
  decrement
};

const CART = '_ct';

function add(product, quantity) {
  let products = ShoppingCart.get();
  let _prod = getProduct(products, product.id);
  if (_prod == undefined) {
    product.quantity = quantity;
    products.unshift(product);
  } else {
    _prod.quantity += quantity;
  }

  localStorage.setItem(CART, encrypt(JSON.stringify(products)));
}

function remove(product) {
  let products = ShoppingCart.get();
  const filteredProducts = products.filter(p => p.id !== product.id);
  localStorage.setItem(CART, encrypt(JSON.stringify(filteredProducts)));
}
/**
 * Total cart amount.
 *
 * @return {number} total
 */
function total() {
  let total = 0;
  let products = ShoppingCart.get();
  products.forEach(product => {
    total += parseFloat(product.base_price) * parseInt(product.quantity);
  });
  return total;
}
/**
 * Total cart items.
 *
 * @return {number} length
 */
function totalItems() {
  let totalItems = 0;
  if (!cartExists()) return 0;
  let products = ShoppingCart.get();
  products.forEach(function (product) {
    totalItems += product.quantity;
  });
  return totalItems;
}
/**
 * Get the cart
 *
 * @return {array} cart.
 */
function get() {
  try {
    return cartExists() ? JSON.parse(decrypt(localStorage.getItem(CART))) : [];
  } catch {
    return [];
  }
}

/**
 * Determine if cart exists in storage.
 *
 * @return {boolean} true or false
 */
function cartExists() {
  return !!localStorage.getItem(CART);
}

/**
 * Decrement item quantity;
 *
 * @param {array} products.
 * @param {string} slug Slug.
 * @return product
 */
function getProduct(products, slug) {
  return products.find(product => product.id == slug);
}

/**
 * Increment product quantity;
 *
 * @param product the product to Increment.
 */
function increment(product) {
  if (!ShoppingCart.cartExists()) return;
  let products = ShoppingCart.get();
  let cartItem = getProduct(products, product.id);
  if (cartItem == undefined) return;
  if (cartItem.quantity == 100) return;
  cartItem.quantity += 1;
  localStorage.setItem(CART, encrypt(JSON.stringify(products)));
}

/**
 * Decrement product quantity;
 *
 * @param product the product to Decrement.
 */
function decrement(product) {
  if (!ShoppingCart.cartExists()) return;
  let products = ShoppingCart.get();
  let cartItem = getProduct(products, product.id);
  if (cartItem == undefined) return;
  cartItem.quantity -= 1;
  if (cartItem.quantity == 0) {
    ShoppingCart.remove(product);
  } else {
    localStorage.setItem(CART, encrypt(JSON.stringify(products)));
  }
}

/**
 * Determine if cart is empty.
 *
 * @return {boolean} true or false
 */
function isEmpty() {
  return totalItems() == 0;
}

/**
 * Remove all cart items from storage.
 *
 */
function clear() {
  if (!ShoppingCart.cartExists()) return;
  localStorage.removeItem(CART);
}
