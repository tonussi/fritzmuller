import store from '../store'

export default async (to, from, next) => {
  await store.getters['lang/locale']

  next()
}
