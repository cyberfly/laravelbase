<template>
    <loading
            :event-bus="$eventBus"
            event-show="show-loading"
            event-hide="hide-loading"
            :label="label">
    </loading>
</template>

<script>

    export default {
        props: {

        },
        mounted() {

        },
        data () {
            return {
                label: this.trans.get('labels.loading'),
            }
        },
        computed: {

        },
        methods: {

        }
    }

</script>