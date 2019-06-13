<template>
    <div class="table-loader">
        <vcl-table
                :rows="rows"
                :columns="columns"
        ></vcl-table>
    </div>
</template>

<script>

    export default {
        props: {
            rows: {
                type: Number,
            },
            columns: {
                type: Number,
            }
        },
        data () {
            return {}
        },
        created() {

        },
        computed: {

        },
        methods: {

        }
    }

</script>

<style>

    .table-loader {
        margin-bottom: 20px;
    }

</style>