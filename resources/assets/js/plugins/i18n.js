import Vue from 'vue';
import VueI18n from 'vue-i18n';
import Locales from '../vue-i18n-locales.generated.js';

Vue.use(VueI18n);

const i18n = new VueI18n({
  locale: localStorage.getItem('locale'),
  messages: Locales
});

export default i18n;
