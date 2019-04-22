<template>

    <!-- Form -->

    <form @submit.prevent="handleSubmit">

        <v-validation-alert :submitted="submitted"></v-validation-alert>

        <div class="row push">
            <div class="col-lg-6">

                <div class="form-group">
                    <v-text
                            v-model="user_data.name"
                            :field_name="'name'"
                            :label="'Name'"
                            :rules="'required'"
                    ></v-text>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="text" name="email" v-model="user_data.email" v-validate="'required|email'" class="form-control" :class="{ 'is-invalid': errors.has('email') }" id="email"   >
                    <div class="invalid-feedback">{{ errors.first('email') }}</div>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password"
                           v-model="user_data.password"
                           v-validate="''"
                           ref="password" class="form-control"
                           :class="{ 'is-invalid': errors.has('password') }"
                           id="password">
                    <div class="invalid-feedback">{{ errors.first('password') }}</div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password"
                           name="password_confirmation"
                           v-model="user_data.password_confirmation"
                           v-validate="password_confirmation_rules"
                           data-vv-as="password" class="form-control"
                           :class="{ 'is-invalid': errors.has('password_confirmation') }"
                           id="password_confirmation">
                    <div class="invalid-feedback">{{ errors.first('password_confirmation') }}</div>
                </div>

                <div class="form-group">

                    <v-select
                            v-model="user_data.roles"
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
        props: [
            'roles'
        ],
        props: {
            user: {
                type: Object,
            },
            roles: {
                type: Array,
            }
        },
        mounted() {
            console.log('roles prop ->', this.roles);
        },
        data () {
            return {
                user_data: {
                    ...this.user,
                    roles: [],
                },
                submitted: false,
            }
        },
        created() {

            // set user_data roles

            const assigned_roles_id = this.user.roles.map(role => role.id);

            this.user_data.roles = assigned_roles_id;
        },
        computed: {

            password_confirmation_rules: function () {

                let rules = null;

                if (this.user_data.password) {
                    rules = 'required|confirmed:password';
                }

                return rules;
            },

            // unset password field if no new password to cater backend validation
            update_user_data: function () {

                let user_data = this.user_data;

                if (!this.user_data.password) {
                    delete user_data.password;
                    delete user_data.password_confirmation;
                }

                return user_data;
            },
        },
        watch: {

        },
        methods: {

            handleSubmit(e) {

                this.submitted = true;

                console.log('user: ', JSON.stringify(this.user_data, null, 2));

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

                const user_id = this.user.id;

                axios
                    .put(route('admin.users.update', user_id), this.update_user_data)
                    .then(response => {
                        console.log('res -->', response);

                        // success notification

                        this.$swal({
                            title: 'Good job!',
                            text: 'User was successfully updated!',
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