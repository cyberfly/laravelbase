<template>

    <!-- Form -->

    <form @submit.prevent="handleSubmit">

        <v-validation-alert :submitted="submitted"></v-validation-alert>

        <div class="row push">
            <div class="col-lg-6">

                <div class="form-group">
                    <v-text
                            v-model="role_data.name"
                            :field_name="'name'"
                            :label="'Name'"
                            :rules="'required'"
                    ></v-text>
                </div>

                <div class="form-group">
                    <v-text
                            v-model="role_data.display_name"
                            :field_name="'display_name'"
                            :label="'Display Name'"
                            :rules="'required'"
                    ></v-text>
                </div>

                <div class="form-group">
                    <v-text
                            v-model="role_data.description"
                            :field_name="'description'"
                            :label="'Description'"
                            :rules="'required'"
                    ></v-text>
                </div>

                <div class="form-group">

                    <v-select
                            v-model="role_data.permissions"
                            :options="permissions"
                            :multiple="true"
                            :label_key="'display_name'"
                            :value_key="'id'"
                            :field_name="'user.permissions'"
                            :label="'Permissions'"
                            :rules="'required'"
                    ></v-select>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>

    </form>

    <!-- END Form -->
</template>

<script>

    export default {
        props: {
            permissions: {
                type: Array,
                required: true,
            }
        },
        mounted() {

        },
        data () {
            return {
                role_data: {
                    name: null,
                    display_name: null,
                    description: null,
                    permissions: [],
                },
                submitted: false,
            }
        },
        created() {

        },
        computed: {

        },
        watch: {

        },
        methods: {

            handleSubmit(e) {

                this.submitted = true;

                console.log('role: ', JSON.stringify(this.role_data, null, 2));

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

                axios
                    .post(route('admin.roles.store'), this.role_data)
                    .then(response => {
                        console.log('res -->', response);

                        // success notification

                        this.$swal({
                            title: 'Good job!',
                            text: 'Role was successfully created!',
                            type: 'success',
                            confirmButtonText: 'Ok'
                        }).then(function() {
                            // redirect to user list
                            window.location.href = route('admin.roles.index');
                        });

                    })
                    .catch(function (error) {
                        console.log('error res -->', error);
                    });

            }
        }
    }
</script>