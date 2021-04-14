import axios from './index'

export default {
  login (userData) {
    return axios.post(process.env.MIX_SENTRY_DSN_API+'api/login', userData)
  },
  register (userData) {
    return axios.post(process.env.MIX_SENTRY_DSN_API+'api/register', userData)
  }
}
