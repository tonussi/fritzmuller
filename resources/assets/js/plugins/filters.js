import Vue from 'vue'
import moment from 'moment'
import i18n from './i18n'

/**
 * Filters
 */
Vue.filter('formatDate', function (value) {
 if (!value) return '';
 return moment(String(value), 'YYYY-MM-DD HH:mm:ss').locale('pt-br').format(i18n.t('misc.datetime'));
});
