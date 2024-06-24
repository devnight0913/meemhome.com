import config from '@/config';
import { AES, enc } from 'crypto-js';

const KEY = '73460461-76b3-440f-bfd4-06b102344011';

/**
 * Format number to BRL Currency.
 *
 * @param {number} number.
 * @param {string} format.
 * @return {string} formatted number.
 */
export function usd_money_format(number, format = config.CURRENCY_SYMBOL) {
  if (number < 0) {
    var absNumber = Math.abs(number);
    return `- ${format}${absNumber.toLocaleString()}`;
  }
  return `${format}${number.toLocaleString()}`;
}

/**
 * Format number to percentage.
 *
 * @param {number} number.
 * @return {string} formatted number.
 */
export function percentage_format(number) {
  if (isNaN(number)) return '-';
  if (number < 0 || number > 100) return '-';
  return `${number.toFixed(2)}%`;
}

/**
 * Get file size.
 *
 * @return {string} size
 */
export function filesize(size) {
  const i = Math.floor(Math.log(size) / Math.log(1024));
  return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
}

/**
 * Encrypts a message.
 *
 * @return {string} data
 */
export function encrypt(data) {
  return AES.encrypt(data, KEY).toString();
}

/**
 * Decrypts serialized ciphertext.
 *
 * @return {string} data
 */
export function decrypt(data) {
  return AES.decrypt(data, KEY).toString(enc.Utf8);
}

/**
 * Delay function.
 * @param {number} secondes.
 * @return {Promise} Promise
 */
export function delay(secondes) {
  var time = secondes * 1000;
  return new Promise(resolve => setTimeout(resolve, time));
}

/**
 * Lazy load images.
 *
 * @return {LazyLoad} LazyLoad
 */
export function lazyLoadImages() {
  var aLazyLoad = new LazyLoad();
  aLazyLoad.update();
}
/**
 * Swal config.
 *
 * @param {number} number.
 * @param {string} format.
 * @return {string} formatted number.
 */
export function swalConfig(title = 'Are you sure?', text = 'You will not be able to reverse this action!', icon = 'warning') {
  return {
    title: title,
    text: text,
    icon: icon,
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'Cancel',
    focusCancel: true,
    showClass: {
      popup: '',
      icon: ''
    },
    hideClass: {
      popup: ''
    }
  };
}
