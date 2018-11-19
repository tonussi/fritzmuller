import Vue from 'vue'
import moment from 'moment'

/**
 * Filters
 */
Vue.filter('datei18n', function (value) {
 if (!value) return '';
 /* Attention YYYY-MM-DD is not a locale! This is the database generic format! */
 return moment(String(value), 'YYYY-MM-DD').locale(localStorage.getItem('locale')).format('LL');
});

Vue.filter('currencyi18n', function (value) {
 if (typeof value !== "number") {
  return value;
 }

 var aux = localStorage.getItem('locale');
 if (aux === undefined) {
   aux = 'BRL';
 }

 var formatter = new Intl.NumberFormat(aux, {
  style: 'currency',
  currency: localStorage.getItem('currency'),
  minimumFractionDigits: 0
 });

 return formatter.format(value);
});
