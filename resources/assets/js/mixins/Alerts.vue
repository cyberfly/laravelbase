<script>
    export default {

        methods: {

            // show success alert

            $showSuccess(message, redirect_to = null) {

                const self = this;

                this.$swal({
                    title: 'Tahniah',
                    text: message,
                    type: 'success',
                    confirmButtonText: 'Ok',
                    timer: 2000,
                }).then(function() {

                    if (redirect_to) {

                        self.$showLoading();

                        window.location.href = redirect_to;
                    }

                });
            },

            // show confirmation to delete Vue generated row
            $showDeleteForm(id, index) {

                this.$swal({
                    title: 'Are you sure to delete this record?',
                    text: 'This action cannot be undo.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                    showLoaderOnConfirm: true,
                }).then((result) => {

                    if(result.value) {

                        this.destroy(id, index);
                    } else {

                    }
                });

            },

            // show success deleted alert

            $showSuccessDeleted(label, redirect_to = null) {

                const self = this;

                this.$swal({
                    title: 'Deleted',
                    text: label + ' was successfully deleted.',
                    type: 'success',
                    confirmButtonText: 'Ok',
                    timer: 2000,
                }).then(function() {

                    if (redirect_to) {

                        self.$showLoading();

                        window.location.href = redirect_to;
                    }

                });
            },

            // show success created alert

            $showSuccessCreated(label, redirect_to = null) {

                const self = this;

                this.$swal({
                    title: 'Congratulation',
                    text: label + ' has been successfully created.',
                    type: 'success',
                    confirmButtonText: 'Ok',
                    timer: 2000,
                }).then(function() {

                    if (redirect_to) {

                        self.$showLoading();

                        window.location.href = redirect_to;
                    }

                });
            },

            // show success updated alert

            $showSuccessUpdated(label, redirect_to = null) {

                const self = this;

                this.$swal({
                    title: 'Congratulation',
                    text: label + ' has been successfully updated.',
                    type: 'success',
                    confirmButtonText: 'Ok',
                    timer: 2000,
                }).then(function() {

                    if (redirect_to) {

                        self.$showLoading();

                        window.location.href = redirect_to;
                    }

                });
            },


        },
    };
</script>