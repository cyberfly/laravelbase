<script>
    export default {

        methods: {

            $showLoading() {
                this.$eventBus.$emit('show-loading', true);
            },

            $hideLoading() {
                this.$eventBus.$emit('hide-loading', true);
            },

        },
    };
</script>