<script>
    export default {

        methods: {

            $linkTo(route_name, params=null) {
                return route(route_name, params);
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

            $showSuccessDeleted(label) {

                this.$swal({
                    title: 'Deleted',
                    text: label + ' was successfully deleted.',
                    type: 'success',
                    confirmButtonText: 'Ok',
                    timer: 2000,
                }).then(function() {


                });
            },

        },
    };
</script>