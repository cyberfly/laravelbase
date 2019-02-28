<template>
    <a class="block block-rounded block-link-pop" :href="link_to">
        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
            <div>

                <trend
                        :data="chart_data"
                        :gradient="line_color"
                        :radius="line_radius"
                        auto-draw
                        smooth>
                </trend>

            </div>
            <div class="ml-3 text-right">
                <p class="text-muted mb-0">
                    {{ label }}
                </p>
                <p class="font-size-h3 font-w300 mb-0">
                    {{ total }}
                </p>
            </div>
        </div>
    </a>
</template>

<script>

    import Trend from 'vuetrend';

    Vue.use(Trend);

    export default {
        props: {
            label: {
                type: String,
            },
            total: {
                type: Number,
            },
            line_color: {
                default: function () {

                    const default_line_color = ['#3c90df', '#3c90df', '#3c90df'];

                    return default_line_color;
                },
                type: Array,
            },
            chart_data: {
                default: function () {

                    const default_data = [0, 2, 5, 9, 5, 10, 3, 5, 0, 0, 1, 8, 2, 9, 0];

                    return default_data;
                },
            },
            line_radius: {
                default: 1,
                type: Number
            },
            link_to: {
                default: 'javascript:void(0)',
                type: String
            }
        },
        computed: {

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
