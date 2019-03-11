<template>
    <a class="block block-rounded block-link-pop"
       :href="link_to" >
        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
            <div class="mr-3">
                <p class="font-size-lg font-w600 mb-0">
                    {{ label }}
                </p>
                <p class="text-muted mb-0">
                    {{ description }}
                </p>
            </div>
            <div class="item item-circle bg-body-light">
                <i class="fa fa-2x" :class="item_class"></i>
            </div>
        </div>
    </a>
</template>

<script>

    export default {

        props: {
            label: {
                type: String|Number,
            },
            description: {
                type: String|Number,
            },
            link_to: {
                default: 'javascript:void(0)',
                type: String
            },
            icon: {
                default: 'fa-tv'
            },
            icon_class: {
                default: 'primary'
            }
        },
        computed: {

            item_class: function () {

                let class_name = this.icon + ' text-' + this.icon_class;

                if (this.theme === 'primary') {
                    class_name = this.icon + ' text-' + this.icon_class;
                }

                if (this.theme === 'xsmooth') {
                    class_name = this.icon + ' text-' + this.icon_class;
                }

                if (this.theme === 'xinspire') {
                    class_name = this.icon + ' text-' + this.icon_class;
                }

                return class_name;

            },

        },
        data () {
            return {

            }
        },
        watch:{

        },
        methods: {

        }
    }

</script>
