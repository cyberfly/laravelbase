<script>

    export default {
        props: {

        },
        mounted() {

        },
        data() {
            return {
                gallery_data : {
                    title: null,
                    description: null,
                    cover_images: [],
                    gallery_images: [],
                    attached_media: [],
                },
                submitted: false
            }
        },
        computed: {

            // return unique media id to be sync at backend
            attached_media: function ()  {

                // combine array to get all attachment id

                const attached_media_id = [...this.gallery_data.gallery_images, ...this.gallery_data.cover_images];

                const unique_attached_media = [...new Set(attached_media_id)];

                return unique_attached_media;
            },

        },
        watch: {
            attached_media() {

                // assign unique attached_media to gallery_data attached_media
                this.gallery_data.attached_media = [...this.attached_media];
            }
        },
        methods: {

            handleSubmit(e) {

                this.submitted = true;

                this.$validator.validate().then(valid => {
                    if (valid) {
                        this.store();
                    }
                    else {
                        // scroll to top

                        window.scrollTo(0,0);
                    }
                });

            },

            store() {

                console.log('submitting into API', this.gallery_data);

                axios
                    .post(route('examples.uploadforms.store'), this.gallery_data)
                    .then(response => {
                        console.log('res -->', response);

                        // success notification

                        this.$swal({
                            title: 'Good job!',
                            text: 'Gallery was successfully created!',
                            type: 'success',
                            confirmButtonText: 'Ok'
                        }).then(function() {
                            // redirect to

                        });

                    })
                    .catch(function (error) {
                        console.log('error res -->', error);
                    });
            }
        }
    }
</script>