<script>
    export default {

        methods: {

            // generate ziggy link to use in Vue template
            $linkTo(route_name, params=null) {

                if (!params) {
                    return route(route_name);
                }

                return route(route_name, params);
            },

            // date time Malaysia format

            $myDateTime(datetime) {
                return moment(datetime, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss');
            },

            // date Malaysia format

            $myDate(datetime) {
                return moment(datetime, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY');
            },

            // time ago

            $timeAgo(date) {
                let time_ago = moment(date).locale(window.default_locale).fromNow();
                return time_ago;
            },

            // today date (db format)

            $today() {
                return moment(new Date()).format('YYYY-MM-DD');
            },

            // reset form

            $resetForm(obj) {

                for (let key in obj) {
                    if (obj.hasOwnProperty(key)) {
                        obj[key] = null;
                    }
                }

            },

        },
    };
</script>