<template>

    <!-- Form -->

    <form @submit.prevent="handleSubmit">

        <v-validation-alert :submitted="submitted"></v-validation-alert>

        <div class="row push">
            <div class="col-lg-6">

                <div class="form-group">
                    <v-text
                            v-model="user.name"
                            :field_name="'name'"
                            :label="'Name'"
                            :rules="'required'"
                    ></v-text>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="text" name="email" v-model="user.email" v-validate="'required|email'" class="form-control" :class="{ 'is-invalid': errors.has('email') }" id="email"   >
                    <div class="invalid-feedback">{{ errors.first('email') }}</div>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" v-model="user.password" v-validate="'required'" ref="password" class="form-control" :class="{ 'is-invalid': errors.has('password') }" id="password">
                    <div class="invalid-feedback">{{ errors.first('password') }}</div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" v-model="user.password_confirmation" v-validate="'required|confirmed:password'" data-vv-as="password" class="form-control" :class="{ 'is-invalid': errors.has('password_confirmation') }" id="password_confirmation">
                    <div class="invalid-feedback">{{ errors.first('password_confirmation') }}</div>
                </div>

                <div class="form-group">

                    <v-select
                            v-model="user.roles"
                            :options="roles"
                            :multiple="true"
                            :label_key="'display_name'"
                            :value_key="'id'"
                            :field_name="'user.roles'"
                            :label="'Roles'"
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
        props: ['roles'],
        mounted() {
            console.log('roles prop ->', this.roles);
        },
        data () {
            return {
                user: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                    roles: [],
                },
                submitted: false,
                selected_roles: []
            }
        },
        computed: {

        },
        watch: {

        },
        methods: {

            handleSubmit(e) {

                this.submitted = true;

                console.log('user: ', JSON.stringify(this.user, null, 2));

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
                    .post(route('admin.users.store'), this.user)
                    .then(response => {
                        console.log('res -->', response);

                        // success notification

                        this.$swal({
                            title: 'Good job!',
                            text: 'User was successfully created!',
                            type: 'success',
                            confirmButtonText: 'Ok'
                        }).then(function() {
                            // redirect to user list
                            window.location.href = route('admin.users.index');
                        });

                    })
                    .catch(function (error) {
                        console.log('error res -->', error);
                    });

            }
        }
    }
</script>