export default {
    data() {
        return {

        }
    },
    methods: {
           async  callApi( method, url, dataObj = null ){
               return await axios({
                   method: method,
                   url: url,
                   data: dataObj,
               })
                   .then(success => {
                       return success
                   })
                   .catch(err => {
                       return err.response
                   })
            },
        info (title,desc,time) {
            this.$Notice.info({
                title: title,
                desc: desc ? desc : 'Info Notification',
                duration: time ? time : 3
            });
        },
        success (title,desc,time) {
            this.$Notice.success({
                title: title,
                desc: desc ? desc : 'Info Notification',
                duration: time ? time : 3
            });
        },
        warning (title,desc,time) {
            this.$Notice.warning({
                title: title,
                desc: desc ? desc : 'Info Notification',
                duration:  time ? time : 3
            });
        },
        error (title,desc,time) {
            this.$Notice.error({
                title: title,
                desc: desc ? desc : 'Info Notification',
                duration: time ? time : 3
            });
        }
    }
}
