<template>

    <div>
        <ul class="v-html-list">
            <li class="" v-for="row in list_data">{{ row[label_key] }}</li>
        </ul>
    </div>

</template>

<script>

    export default {
        props: {
            list_data: {
                type: Array,
                required: true,
            },
            label_key: {
                type: String,
                required: true,
            }
        },
        mounted() {

        },
        data () {
            return {

            }
        },
        created()
        {

        },
        methods: {

        }
    }
</script>

<style>

    .v-html-list {
        list-style: none;
    }

</style>
