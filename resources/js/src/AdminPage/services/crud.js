import axios from './index'

export default {
  getList (paramsData) { 
    return axios.get(process.env.MIX_SENTRY_DSN_API+paramsData.api, paramsData)
  },
  getElementData (paramsData) { 
    return axios.post(process.env.MIX_SENTRY_DSN_API+paramsData.api, paramsData)
  },
  getListData (paramsData) { 
    return axios.get(process.env.MIX_SENTRY_DSN_API+paramsData.api, paramsData)
  },
  addElement (paramsData) { 
    return axios.post(process.env.MIX_SENTRY_DSN_API+paramsData.api, paramsData.elementData)
  },
  addElementMultimedia (paramsData, formData) { 
    const config = {  headers: { 'content-type': 'multipart/form-data' } }
    return axios.post(process.env.MIX_SENTRY_DSN_API+paramsData.api, formData, config)
  },
  updateElement (paramsData) { 
    return axios.post(process.env.MIX_SENTRY_DSN_API+paramsData.api, paramsData.elementData)
  },
  updateElementMultimedia (paramsData, formData) { 
    const config = {  headers: { 'content-type': 'multipart/form-data' } }
    return axios.post(process.env.MIX_SENTRY_DSN_API+paramsData.api, formData, config)
  },
  updateActiveElement (paramsData) { 
    return axios.post(process.env.MIX_SENTRY_DSN_API+paramsData.api, paramsData.elementData)
  },
  deleteElement (paramsData) {
    return axios.post(process.env.MIX_SENTRY_DSN_API+paramsData.api, paramsData.elementData)
  },
  multiDeleteElement (paramsData) {
    return axios.delete(process.env.MIX_SENTRY_DSN_API+paramsData.api, {data:paramsData})
  },
  hello(){
    return "hellou"
  }
}
