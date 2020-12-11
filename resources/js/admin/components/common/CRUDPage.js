export default {

    computed: {



        notificationColor() {
            return this.notification.error ? "red" : "primary"
        },

    },

    watch: {

        'dialog.delete.open': function(val) {
            val || this.close('delete')
        },

        'notification.error': function (value) {
            if(!value)
                this.notification.error = false;
        },
    },

    created () {
        this.initialize()
    },

    mounted () {
    },

    methods: {
        initialize () {

            axios.get(this.$api_url + this.SLUG + "/meta")
                .then(response => {
                    this.data.items = response.data.data
                    this.data.meta = response.data.meta
                    console.log(this.data.meta)
                    this.dataTable.loading = false;
                })
                .catch(error => {
                    this.dataTable.loading = false;
                })
        },

        setTab(field, value, tabName) {
            this.dataTable.filter = {}
            this.dataTable.filter[field] = value
            this.activeTab = tabName
        },

        editItem (item) {
            this.editedIndex = this.items.indexOf(item)
            this.item.created = Object.assign({}, item)
            this.dialog.delete = true
        },


        action(action, item, confirmation) {

            this.dialog[action].index = this.data.items.indexOf(item)
            this.dialog[action].item = Object.assign({}, item)

            if(confirmation)
                this.dialog[action].open = true
            else {
                if(this.data.items[this.dialog[action].index].status !== this.dialog[action].status) {
                    this.dialog[action].item.status = this.dialog[action].status;

                    this.confirm(action)
                }
            }
        },

        confirm(action) {
            let id = this.dialog[action].item.id ? this.dialog[action].item.id : '';
            let payload = this.dialog[action].payload ? this.dialog[action].payload : this.dialog[action].item;
            axios({
                url:  this.$api_url + this.SLUG + "/" + id,
                method: this.dialog[action].method,
                data: payload
            })
            .then(
                response => {

                    switch (this.dialog[action].status) {
                        case this.status.DELETED:
                            this.data.items.splice(this.dialog[action].index, 1)
                            break;
                        case this.status.UPDATED:
                            Object.assign(this.data.items[this.dialog[action].index], this.dialog[action].item)
                            break;
                        case this.status.CREATED:
                            this.dialog[action].item = response.data;
                            this.data.items.push(this.dialog[action].item)
                            break;
                        default:
                            this.data.items[this.dialog[action].index].status = this.dialog[action].status
                    }

                    this.dialog[action].index = -1;
                    this.notify(this.dialog[action].onSuccess)
                    this.dialog[action].item = Object.assign({}, this.dialog.defaultItem)
                }
            )
            .catch(error => {
                this.notify(this.dialog[action].onError, true)
                console.log(error);
            })

            this.close(action)
        },

        close (action) {
            this.dialog[action].open = false
        },

        cancelField () {
        },


        closeField () {
        },

        notify(message, error = false) {
            this.notification.show = true;
            this.notification.text = message;
            this.notification.error = error;
        }

    },
}
