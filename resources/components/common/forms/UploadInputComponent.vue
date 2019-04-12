<template>
    <div>
        <label :for="id">{{ label }} <span v-if="isRequired" class="text-danger">*</span></label>
        <vue-dropzone
                :options="config"
                :duplicateCheck="!allow_duplicate"
                :useCustomSlot=true
                @vdropzone-sending="sendingEvent"
                @vdropzone-success="successUpload"
                @vdropzone-removed-file="removeFile"
                ref="myVueDropzone"
                id="dropzone"
        >
            <div class="dropzone-custom-content">
                <h3 class="dropzone-custom-title">{{ dropzone_title }}</h3>
                <div class="subtitle">{{ dropzone_subtitle }}</div>
            </div>
        </vue-dropzone>
    </div>
</template>

<script>

    import vue2Dropzone from 'vue2-dropzone';
    import 'vue2-dropzone/dist/vue2Dropzone.min.css';

    export default {
        components: {
            vueDropzone: vue2Dropzone
        },
        props: {
            value: {},
            field_name: {
                required: true
            },
            label: {
                required: true
            },
            model_type: {
                default: null,
            },
            model_id: {
                default: null,
            },
            allow_duplicate: {
                default: false,
            },
            dropzone_title: {
                default: 'Drag and drop to upload file'
            },
            dropzone_subtitle: {
                default: '...or click to select a file from your computer'
            },
            allowed_types: {
                default: null
            },
            limit: {
              default: null,
            },
            max_filesize: {
                default: 2.0
            },
            default_attachments: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            return_object: {
                default: false,
            },
            id: {
                default: '',
                type: String
            },
            rules: {
                default: '',
                type: String
            },
        },
        mounted: function () {

            // auto attached default attachments if exist

            if (this.default_attachments.length > 0) {

                for (let attachment of this.default_attachments) {

                    let file = { size: 123, name: attachment.file_name, type: attachment.mime_type };
                    let url = attachment.url;

                    // auto attached default attachments

                    this.$refs.myVueDropzone.manuallyAddFile(file, url);

                    this.attached_media.push(attachment);
                }

                // notify parent form of latest attached_media_id

                this.updateParentValue(this.attached_media_id);
            }

        },
        data: function () {
            return {
                attached_media: [],
                config: {
                    paramName: 'files',
                    thumbnailWidth: 150,
                    uploadMultiple: true,
                    parallelUploads: 5,
                    acceptedFiles: this.allowed_types,
                    maxFilesize: this.max_filesize,
                    maxFiles: this.limit,
                    addRemoveLinks: true,
                    url: route('uploads.store', { 'collection_name': this.field_name }),
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    }
                }
            };
        },
        computed: {

            isRequired: function ()  {

                if (!this.rules) {
                    return false;
                }

                return (typeof this.rules === 'string')
                    ? this.rules.includes('required')
                    : this.rules['required'];

            },

            collection_name: function ()  {
                return this.field_name;
            },

            attached_media_id: function ()  {

                if (this.return_object === true) {
                    return this.attached_media;
                }
                else {

                    // get attached_media_id array
                    const attached_media_id = this.attached_media.map(media => media.id);

                    // get unique array of attached_media_id
                    const unique_attached_media_id = [...new Set(attached_media_id)];

                    return unique_attached_media_id;

                }
            },
        },
        methods: {

            sendingEvent (file, xhr, formData) {

                if (this.model_type) {
                    formData.append('model_type', this.model_type);
                }

                if (this.model_id) {
                    formData.append('model_id', this.model_id);
                }

            },

            successUpload(file, response) {

                const uploaded_files = response.uploaded_files[this.collection_name];

                uploaded_files.forEach(attachment => {

                    this.attached_media.push(attachment);

                });

                // notify parent form of latest attached_media_id

                this.updateParentValue(this.attached_media_id);
            },

            removeFile(file, error, xhr) {

                const file_name = file.name;

                // get attachment id of deleted file_name

                let attachment_id = null;

                for (let attachment of this.attached_media) {

                    if (attachment.file_name === file_name) {

                        attachment_id = attachment.id;
                        break;
                    }
                }

                if (!attachment_id) {
                    return false;
                }

                axios
                    .delete(route('uploads.destroy', { attachment_id: attachment_id }))
                    .then(response => {
                        console.log('res -->', response);

                        // delete file from all attached media

                        for (let i = 0; i < this.attached_media.length; i++) {

                            if (this.attached_media[i].file_name === file_name) {

                                this.$delete(this.attached_media, i);
                            }
                        }

                        // notify parent form of latest attached_media_id

                        this.updateParentValue(this.attached_media_id);

                    })
                    .catch(function (error) {
                        console.log('error res -->', error);
                    });
            },

            getValidationRules() {
                return this.rules;
            },

            updateParentValue(value) {
                this.$emit('input', value);
            },
        }
    }

</script>

<style>

    .vue-dropzone {
        border: 1px dashed #d8dfed;
    }

    .vue-dropzone .dz-preview .dz-details {
        /*background-color: white;*/
        /*color: #6c757d;*/
    }

    .vue-dropzone .dz-preview .dz-remove {
        /*color: #6c757d;*/
    }

    .dropzone-custom-content {
        text-align: center;
    }

    .dropzone-custom-title {
        margin-top: 0;
        color: #00b782;
    }

    .subtitle {
        color: #314b5f;
    }
</style>