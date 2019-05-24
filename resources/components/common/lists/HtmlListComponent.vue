<template>

    <div>

        <ul class="v-html-list">
            <li class="" v-for="(row, index) in list_data_excerpt" :key="index" >
                <span class="badge badge-info">{{ row[label_key] }}</span>
            </li>
        </ul>

        <template v-if="list_data_balance > 0">
            <button @click="showModal()" class="btn btn-sm btn-info">+ {{ list_data_balance }}</button>

            <!--modal-->

            <b-modal ref="actionModalRef"
                     size="lg"
                     :title="list_title"
                     :header-class="'bg-primary-dark'"
                     :header-text-variant="'light'"
            >
                <div class="d-block">

                    <div class="form-row">

                        <div class="form-group col-md-12">

                            <ul class="v-html-list">
                                <li class="" v-for="(row, index) in list_data" :key="index" >{{ row[label_key] }}</li>
                            </ul>


                        </div>

                    </div>

                </div>
                <div slot="modal-footer">

                </div>
            </b-modal>

            <!--end modal-->
        </template>
    </div>

</template>

<script>

    export default {
        props: {
            list_data: {
                type: Array,
                required: true,
            },
            list_title: {
                required: true,
            },
            label_key: {
                type: String,
                required: true,
            },
            limit: {
                default: 5,
            }
        },
        mounted() {

        },
        computed:{

            list_data_excerpt() {
                return this.limit ? this.list_data.slice(0, this.limit) : this.list_data;
            },

            list_data_balance() {
                return this.list_data.length - this.limit;
            },

        },
        data () {
            return {

            }
        },
        created()
        {

        },
        methods: {

            showModal() {
                this.$refs.actionModalRef.show();
            },
        }
    }
</script>

<style>

    .v-html-list {
        list-style: none;
        padding-left: 0px;
    }

</style>
