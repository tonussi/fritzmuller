import axios from 'axios'
import store from '../store'
import router from '../router'
import i18n from '../plugins/i18n'

window.axios = require('axios');

// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    request.headers.common['Authorization'] = `Bearer ${token}`
  }

  const locale = store.getters['lang/locale']
  if (locale) {
    request.headers.common['Accept-Language'] = locale
  }

  // request.headers['X-Socket-Id'] = Echo.socketId()
  return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const { status } = error.response

  if (status >= 500) {
    alert (i18n.t('alerts.error_alert_text') + ': ' + response);
  }

  if (status === 401 && store.getters['auth/check']) {
    alert (i18n.t('alerts.token_expired_alert_text'));

    store.commit('auth/logout')
    router.push({ name: 'login' })
  }

  return Promise.reject(error)
})
