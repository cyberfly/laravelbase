<template>

    <div>

        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ trans.get('labels.notification_list') }}</h3>
            </div>
            <div class="block-content">

                <table class="table table-striped table-borderless table-vcenter">
                    <thead class="thead-light">
                    <tr>
                        <th colspan="2">{{ trans.get('labels.detail') }}</th>
                        <th>{{ trans.get('labels.date') }}</th>
                        <th class="text-center" style="width: 100px;">{{ trans.get('labels.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                        <tr v-for="(notification, index) in notification_data.data" :key="notification.id">
                            <td class="text-center" style="width: 65px;">
                                <i class="fa fa-2x" :class="notificationStyle(notification.data.type)" ></i>
                            </td>
                            <td>
                                <div class="text-muted mt-2 mb-1">{{ notification.data.message }}</div>
                                <span v-html="readBadge(notification.read_at)"></span>
                            </td>
                            <td>
                                <span class="font-size-sm">Dihantar {{ $timeAgo(notification.created_at) }} oleh <a href="javascript:void(0);">SISTEM</a><br>pada <em>{{ $myDateTime(notification.created_at) }}</em></span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a :href="$linkTo('usernotifications.show', notification.id)" class="btn btn-sm btn-secondary" v-b-tooltip.hover :title="trans.get('labels.view')" >
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <pagination :data="notification_data" @pagination-change-page="getNotificationsData"></pagination>

            </div>
        </div>

    </div>

</template>

<script>

    export default {
        props: {

        },
        mounted() {
            this.getNotificationsData();
        },
        data () {
            return {
                notification_data: {},
                search_data: this.getSearchData(),
                search_options: [
                    {
                        key: 'name',
                        label: 'Name',
                    },
                    {
                        key: 'email',
                        label: 'Email',
                    },
                ],
            }
        },
        created()
        {

        },
        methods: {

            getNotificationsData(page = 1) {

                const params = {
                    page: page,
                    ...this.search_data
                };

                const url = route('usernotifications.indexdata', params);

                axios.get(url)
                    .then(response => {
                        this.notification_data = response.data;
                    });
            },

            getSearchValue: _.debounce(function (value) {
                let search_value = value.search;

                // perform ajax search

                this.getNotificationsData();

            }, 300),

            getSearchData() {

                let search_data = {};

                return search_data;
            },

            notificationStyle(type) {

                let notification_style = 'text-primary';
                let notification_icon = 'fa-exclamation-circle';

                if (type === 'success') {

                    notification_style = 'text-success';
                    notification_icon = 'fa-check-circle';

                }

                if (type === 'warning') {

                    notification_style = 'text-warning';
                    notification_icon = 'fa-exclamation-circle';

                }

                if (type === 'danger') {

                    notification_style = 'text-danger';
                    notification_icon = 'fa-times-circle';

                }

                return notification_style + ' ' + notification_icon;

            },

            readBadge(read_at) {

                if (read_at) {

                    let read_badge = '<span class="badge badge-info"><i class="fa fa-check-circle mr-1"></i> ' + this.trans.get('labels.already_read') + '</span>';

                    return read_badge;
                }

                return null;

            },

        }
    }
</script>
