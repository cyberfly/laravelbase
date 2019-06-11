<template>
    <transition name="fade">
        <div v-if="showValidationAlert && errors.any()" class="alert alert-danger alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="alert-heading font-size-h4 my-2">{{ trans.get('messages.validation_error_header') }}</h3>
            <p class="mb-0">{{ trans.get('messages.validation_error_message') }}</p>
            <ul>
                <li v-for="error in errors.all()">{{ error }}</li>
            </ul>
        </div>
    </transition>
</template>

<script>

    export default {
        inject: ['$validator'],
        props: {
            value: {},
            submitted: {
                default: false,
                required: true
            },
            validate_on_submit: {
                type: Boolean,
                default: false
            }
        },
        mounted() {

        },
        computed: {

            showValidationAlert() {

                if (this.validate_on_submit) {

                    if (!this.submitted) {
                        return false;
                    }

                }

                return true;

            },

        },
        methods: {

        }
    }

</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>