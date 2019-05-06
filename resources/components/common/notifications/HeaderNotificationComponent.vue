<template>
    <div class="dropdown d-inline-block">
        <button type="button" class="btn btn-dual" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="badge badge-secondary badge-pill">{{ unread_count_data }}</span>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
            <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                {{ trans.get('labels.notifications') }}
            </div>
            <ul class="nav-items my-2">

                <li v-for="notification in notifications_data">
                    <a class="text-dark media py-2" :href="$linkTo('usernotifications.show', notification.id)">
                        <div class="mx-3">
                            <i class="fa fa-fw" :class="notificationStyle(notification.data.type)"></i>
                        </div>
                        <div class="media-body font-size-sm pr-2">
                            <div class="font-w600">{{ notification.data.message }}</div>
                            <div class="text-muted font-italic">{{ timeAgo(notification.created_at) }}</div>
                        </div>
                    </a>
                </li>

            </ul>
            <div class="p-2" v-if="!notifications_data.length">
                <a class="btn btn-light btn-block text-center" href="javascript:void(0)">
                    No new notification
                </a>
            </div>
            <div class="p-2 border-top">
                <a class="btn btn-light btn-block text-center" :href="$linkTo('usernotifications.index')">
                    <i class="fa fa-fw fa-eye mr-1"></i> View All
                </a>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        props: {
            notifications: {
                type: Array,
                required: true,
            },
            unread_count: {
                type: Number,
                required: true,
            },
        },
        computed: {

        },
        data () {
            return {
                notifications_data: this.notifications,
                unread_count_data: this.unread_count,
            }
        },
        watch:{

        },
        methods: {

            timeAgo(date) {
                let time_ago = moment(date).fromNow();
                return time_ago;
            },

            viewNotification() {
                this.decreaseUnreadCount();
            },

            decreaseUnreadCount() {
                if (this.unread_count_data > 0) {
                    this.unread_count_data--;
                }
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


        }
    }

</script>
