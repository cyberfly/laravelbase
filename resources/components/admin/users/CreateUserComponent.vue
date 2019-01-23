<template>

    <!-- Form -->

    <form @submit.prevent="handleSubmit">

        <div v-if="submitted && errors.any()" class="alert alert-danger alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="alert-heading font-size-h4 my-2">Validation Error</h3>
            <p class="mb-0">There is an error with your submission. Please fix the errros below to continue.</p>
            <ul>
                <li v-for="error in errors.all()">{{ error }}</li>
            </ul>
        </div>

        <div class="row push">
            <div class="col-lg-6">

                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" v-model="user.name" v-validate="'required'" class="form-control" :class="{ 'is-invalid': errors.has('name') }" id="name"   >
                    <div class="invalid-feedback">{{ errors.first('name') }}</div>
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
                    <label for="roles">Role</label>
                    <select name="roles" v-model="user.roles" v-validate="'required'" class="form-control" id="roles" multiple>
                        <option v-for="role in roles" :value="role.id" >{{ role.name }}</option>
                    </select>
                    <div class="invalid-feedback">{{ errors.first('roles') }}</div>
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
            }
        },
        methods: {

            handleSubmit(e) {

                this.submitted = true;

                this.$validator.validate().then(valid => {
                    if (valid) {
                        console.log('user -->', this.user);
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
