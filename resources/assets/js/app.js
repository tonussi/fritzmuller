import Vue from 'vue';
import store from './store';
import router from './router';
import i18n from './plugins/i18n';
import App from './components/common/App';

import './plugins';
import './components/common';

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
