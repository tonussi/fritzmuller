import Vue from 'vue'
import moment from 'moment'

/**
 * Filters
 */
Vue.filter('datei18n', function (value) {
  if (!value) return '';
  
  var auxLocale = localStorage.getItem('locale');
  if (auxLocale === null) {
    auxLocale = 'pt-BR';
  }
  
  /* Attention YYYY-MM-DD is not a locale! This is the database generic format! */
  return moment(String(value), 'YYYY-MM-DD').locale(auxLocale).format('LL');
});

Vue.filter('currencyi18n', function (value) {
  if (typeof value !== "number") return value;

  var auxLocale = localStorage.getItem('locale');
  if (auxLocale === null) {
    auxLocale = 'pt-BR';
  }

  var formatter = new Intl.NumberFormat(auxLocale, {
    style: 'currency',
    currency: localStorage.getItem('currency'),
    minimumFractionDigits: 0
  });

  return formatter.format(value);
});
