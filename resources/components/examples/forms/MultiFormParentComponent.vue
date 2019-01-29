<script>

    export default {
        props: {
            users: {
                required: true
            }
        },
        mounted() {
            console.log('users prop ->', this.users);
        },
        provide() {
            return {
                parentValidator: this.$validator,
            }
        },
        data() {
            return {
                submitted: false
            }
        },
        methods: {

            setUser(value, index) {
                this.users[index] = Object.assign(this.users[index], value);
            },

            handleSubmit(e) {

                this.submitted = true;

                console.log('users: ', JSON.stringify(this.users, null, 2));

                // perform validation on all child component form

                let validationArray = this.$children.map(function(child){
                    return child.$validator.validateAll();
                });

                window.Promise.all(validationArray).then((v) => {

                    v.some( element => { if ( element == false ) { throw "error exists in child component";} });

                    // if everything okay, submit the form

                    this.store();


                }).catch(() => {

                });
            },

            store() {

                const data = {
                    'users': this.users
                };

                console.log('submitting into API', data);

                axios
                    .post(route('examples.multiforms.store'), data)
                    .then(response => {
                        console.log('res -->', response);

                        // success notification

                        this.$swal({
                            title: 'Good job!',
                            text: 'User was successfully imported!',
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