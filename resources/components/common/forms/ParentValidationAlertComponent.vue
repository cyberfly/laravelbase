<template>
    <div v-if="submitted && errors.items.length" class="alert alert-danger alert-dismissable" role="alert" >
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="alert-heading font-size-h4 my-2">Submission Error</h3>
        <p class="mb-0">There is an error with your submission. Please fix all the error below to continue.</p>
        <ul v-if="show_error_details">
            <li v-for="(el, key) in errors.items" >{{ el.msg }}</li>
        </ul>
    </div>
</template>

<script>

    export default {
        props: {
            submitted: {
                default: false,
                required: true
            },
            show_error_details: {
                default: true
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
