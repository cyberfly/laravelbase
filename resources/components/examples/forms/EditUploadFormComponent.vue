<template>

    <div>

        <!-- parent component form -->

        <form @submit.prevent="handleSubmit">

            <div class="row">

                <div class="col-lg-6">

                    <div class="form-group">
                        <v-text
                                v-model="gallery_data.title"
                                :field_name="'title'"
                                :label="'Gallery Title'"
                                :rules="'required'"
                        ></v-text>
                    </div>

                    <div class="form-group">
                        <v-text
                                v-model="gallery_data.description"
                                :field_name="'description'"
                                :label="'Gallery Description'"
                                :rules="'required'"
                        ></v-text>
                    </div>

                    <div class="form-group">
                        <v-upload
                                v-model="gallery_data.cover_images"
                                :field_name="'cover_images'"
                                :label="'Cover Images'"
                                :rules="'required'"
                                :limit="2"
                                :default_attachments="uploaded_cover_images"
                                v-validate="'required'"
                                data-vv-name="cover_images"
                                :data-vv-as="'Cover Images'"
                        ></v-upload>
                        <div class="invalid-feedback">{{ errors.first('cover_images') }}</div>
                    </div>

                    <div class="form-group">
                        <v-upload
                                v-model="gallery_data.gallery_images"
                                :field_name="'gallery_images'"
                                :label="'Gallery Images'"
                                :rules="'required'"
                                :default_attachments="uploaded_gallery_images"
                                v-validate="'required'"
                                data-vv-name="gallery_images"
                                :data-vv-as="'Gallery Images'"
                        ></v-upload>
                        <div class="invalid-feedback">{{ errors.first('gallery_images') }}</div>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-secondary">Save</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>

    </div>

</template>

<script>

    export default {
        props: {
            gallery: {
                required: true
            },
            uploaded_files: {

            }
        },
        mounted() {

        },
        data() {
            return {
                gallery_data : {
                    ...this.gallery,
                    cover_images: [],
                    gallery_images: [],
                    attached_media: [],
                },
                uploaded_cover_images: _.get(this.uploaded_files, 'cover_images', []),
                uploaded_gallery_images: _.get(this.uploaded_files, 'gallery_images', []),
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
                        this.update();
                    }
                    else {
                        // scroll to top

                        window.scrollTo(0,0);
                    }
                });

            },

            update() {

                console.log('submitting into API', this.gallery_data);

                const gallery_id = this.gallery.id;

                axios
                    .put(route('examples.uploadforms.update', gallery_id), this.gallery_data)
                    .then(response => {
                        console.log('res -->', response);

                        // success notification

                        this.$swal({
                            title: 'Good job!',
                            text: 'Gallery was successfully updated!',
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