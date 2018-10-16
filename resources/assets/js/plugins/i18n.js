import Vue from 'vue';
import VueI18n from 'vue-i18n';
import Locales from '../vue-i18n-locales.generated.js';
import extras from './extras';

Vue.use(VueI18n);

const i18n = new VueI18n({
  locale: extras.getSystemLang(Locales),
  messages: Locales
});

export default i18n;
