<template>
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
</template>

<script>

    export default {
        inject: ['$validator'],
        props: {
            value: {},
            submitted: {
                default: false,
                required: true
            }
        },
        mounted() {

        },
        computed: {

        },
        methods: {

        }
    }

</script>
