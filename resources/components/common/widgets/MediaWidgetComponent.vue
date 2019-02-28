<template>
    <a class="block block-rounded block-link-pop"
       :class="bg_class"
       :href="link_to" >
        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
            <div class="mr-3">
                <p class="text-white font-size-lg font-w600 mb-0">
                    {{ label }}
                </p>
                <p class="text-white-75 mb-0">
                    {{ description }}
                </p>
            </div>
            <div class="item">
                <i class="fa fa-2x" :class="item_class"></i>
            </div>
        </div>
    </a>
</template>

<script>

    export default {

        props: {
            label: {
                type: String,
            },
            description: {
                type: String,
            },
            link_to: {
                default: 'javascript:void(0)',
                type: String
            },
            theme: {
                default: 'primary'
            },
            icon: {
                default: 'fa-tv'
            }
        },
        computed: {

            bg_class: function () {

                let class_name = 'bg-gd-primary';

                if (this.theme === 'primary') {
                    class_name = 'bg-gd-primary';
                }

                if (this.theme === 'xsmooth') {
                    class_name = 'bg-xsmooth';
                }

                if (this.theme === 'xinspire') {
                    class_name = 'bg-xinspire';
                }

                return class_name;

            },

            item_class: function () {

                let class_name = this.icon + ' ' + 'text-white-75';

                if (this.theme === 'primary') {
                    class_name = this.icon + ' ' + 'text-white-75';
                }

                if (this.theme === 'xsmooth') {
                    class_name = this.icon + ' ' + 'text-xsmooth-lighter';
                }

                if (this.theme === 'xinspire') {
                    class_name = this.icon + ' ' + 'text-xinspire-lighter';
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
