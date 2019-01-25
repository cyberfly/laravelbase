<script>

    export default {
        mounted() {
            console.log('inline template component');
        },
        data () {
            return {
                message: 'This is test message'
            }
        },
        methods: {
            store() {
                alert('Test inline component method')
            }
        }
    }
</script>