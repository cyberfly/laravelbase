<script>

    export default {
        inject: ['parentValidator'],
        props: {
            data: {
                required: true,
            },
            index: {
                required: true,
            },
            submitted: {
                default: false,
            }
        },
        mounted () {

        },
        data () {
            return {
                user: {

                },
            }
        },
        created () {
            this.user = this.data;
        },
        watch: {
            'user': {
                handler: function (object) {
                    console.log('user updated', JSON.stringify(object, null, 2));

                    this.updateParent();
                },
                deep: true
            },
        },
        methods: {

            updateParent() {
                this.$emit('on-change', this.user, this.index)
            }
        }
    }
</script>