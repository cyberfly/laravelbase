<script>
    export default {

        methods: {

            $linkTo(route_name, params=null) {
                return route(route_name, params);
            },

        },
    };
</script>