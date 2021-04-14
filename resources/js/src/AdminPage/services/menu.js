import axios from './index'

export default {
    getMenuSideBar (paramsData) { //paramsData
        return axios.post(process.env.MIX_SENTRY_DSN_API+'api/menu', paramsData)
        /*
        axios.post(process.env.MIX_SENTRY_DSN_API+'api/menu', paramsData)
        .then(response => {
          if (response.status == 200) {
            var data = response.data;
            return data;
          }
        })
        .finally(() => {
          this.loading = false; 
        });
        */
   },
}