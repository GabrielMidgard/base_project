import Vue from 'vue'
import CripNotice from "crip-vue-notice"

Vue.prototype.notification = function (type, message) { 
    var title = '';
    if(type == 'success'){
        title = "Noticia de éxito "
    }
    else if(type == 'warning'){
        title = "Noticia de advertencia"
    }
    else if(type == 'info'){
        title = "Noticia de información"
    }
    else if(type == 'error'){
        title = "Noticia de error"
    }
    
    switch(type){
        case 'success': 
            this.$notice.success({
                title: title,
                description: message,
                closable: false,
                lassName: "open-normal",
            })
        break;

        case 'warning':
            this.$notice.warning({
                title: title,
                description: message,
                closable: false,
            }) 
        break;

        case 'info': 
            this.$notice.info({
                title: title,
                description: message,
                closable: false,
            })
        break;
        
        case 'error':
            this.$notice.error({
                title: title,
                description: message,
                closable: false,
            }) 
        break;
    
        default:
            this.notice = new CripNotice({
                title: 'Noticia',
                description:message,
                className: "open-normal",
                duration: 20,
              })
        break;
    }
};