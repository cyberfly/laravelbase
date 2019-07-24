<template>
    <div>
        <label for="">{{ label }}</label> <span v-if="isRequired" class="text-danger">*</span>

        <div class="input-group">

            <input type="text"
                   :name="field_name"
                   v-model="selected_display_value"
                   v-validate="getValidationRules()"
                   :data-vv-as="label"
                   class="form-control"
                   :class="{ 'is-invalid': errors.has(field_name) }"
                   readonly="readonly"
                   aria-label="">

            <div v-if="true" class="input-group-append">

                <button @click="showModal()" type="button" class="btn btn-primary" >
                    <i class="fa fa-search mr-1"></i>
                </button>

            </div>

        </div>

        <div class="invalid-feedback">{{ errors.first(field_name) }}</div>

        <!--search modal-->

        <b-modal ref="searchModalRef"
                 size="lg"
                 :title="searchModalTitle"
                 :header-class="'bg-primary-dark'"
                 :header-text-variant="'light'"
                 :footer-class="'bg-light'"
        >
            <div class="d-block">
                <div class="form-row">

                    <div class="form-group col">
                        <v-search-field
                                v-model="search_data"
                                @input="getSearchValue">
                        </v-search-field>
                    </div>

                    <template v-if="showLoading">
                        <v-table-loader
                                :rows="5"
                                :columns="columnCount"
                        ></v-table-loader>
                    </template>

                    <template v-else>

                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <slot name="thead">
                                        <th>Id</th>
                                    </slot>
                                    <th class="text-center" style="width: 100px;">{{ trans.get('labels.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(row, index) in result_data.data" :key="row.id">
                                    <slot name="tbody" :row="row">
                                        <td>
                                            {{ row.id }}
                                        </td>
                                    </slot>
                                    <td>
                                        <div class="align-center">
                                            <button type="button" class="btn btn-sm btn-success"
                                                    v-b-tooltip.hover
                                                    :title="trans.get('labels.select')"
                                                    @click="selectItem(row)">
                                                <i class="far fa-hand-point-right"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-if="emptyResult">
                                    <td :colspan="columnCount">
                                        {{ trans.get('messages.empty_result') }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <pagination :data="result_data" @pagination-change-page="getSearchResult"></pagination>

                    </template>

                </div>
            </div>
            <div slot="modal-footer">
                <button @click="hideModal()" type="button" class="btn btn-sm btn-primary">{{ trans.get('labels.close') }}</button>
            </div>
        </b-modal>

        <!--end of search modal-->
    </div>
</template>

<script>

    export default {
        inject: ['$validator'],
        props: {
            value: {},
            field_name: {
                required: true,
            },
            label: {
                type: String,
                default: 'Keyword'
            },
            api_route: {
                required: true,
                type: String,
            },
            api_param: {
                type: Object,
                default: function () {
                    return {};
                },
            },
            value_type: {
                type: String,
                default: 'key',
                validator: value => {

                    // value_type only accept string 'key' and 'object'

                    if (value !== 'key' && value !== 'object') {
                        return false;
                    }

                    return true;
                }
            },
            value_key: {
                type: String,
                default: 'id'
            },
            // if value_type object, key for text value
            display_key: {
                type: String,
                default: null
            },
            // default selected_display_value
            display_value: {
                type: String,
                default: null
            },
            rules: {
                default: '',
                type: String
            },
            columns: {
                default: 4
            },
        },
        computed: {

            isRequired() {

                if (!this.rules) {
                    return false;
                }

                return (typeof this.rules === 'string')
                    ? this.rules.includes('required')
                    : this.rules['required'];

            },

            searchModalTitle() {
                return this.trans.get('labels.search') + ' ' + this.label;
            },

            emptyResult() {

                if (this.result_data.data) {

                    if (this.result_data.data.length < 1) {
                        return true;
                    }

                }

                return false;
            },

            columnCount() {
                return this.columns + 1;
            },

        },
        data () {
            return {
                result_data: {},
                search_data: {
                    limit: 20
                },
                showLoading: false,
                selected_data: null,
                selected_display_value: null,
            }
        },
        created () {

            // set default text field value, not component value

            if (this.value_type === 'key') {

                if (this.display_value) {
                    this.selected_display_value = this.display_value;
                }
                else {

                    if (this.value) {
                        this.selected_display_value = this.value;
                    }

                }

            }
            else {

                if (this.display_value) {
                    this.selected_display_value = this.display_value;
                }

            }

        },
        watch:{

            display_value: function (value, old_value) {
                this.selected_display_value = value;
            },

        },
        methods: {

            getValidationRules() {
                return this.rules;
            },

            showModal() {

                this.$refs.searchModalRef.show();

                this.getSearchResult();
            },

            hideModal() {

                this.$refs.searchModalRef.hide();
            },

            selectItem(data) {

                this.selected_data = data;

                if (this.value_type === 'key') {

                    if (this.display_key) {
                        this.selected_display_value = data[this.display_key];
                    }
                    else {
                        this.selected_display_value = data[this.value_key];
                    }

                }
                else {
                    this.selected_display_value = data[this.display_key];
                }

                if (this.value_type !== 'object') {

                    let value = data[this.value_key];

                    this.updateParentValue(value);
                }
                else {
                    this.updateParentValue(data);
                }

                this.hideModal();

            },

            getSearchValue: _.debounce(function (value) {
                let search_value = value.search;

                // perform ajax search

                this.getSearchResult();

            }, 300),

            // get search data via REST API

            getSearchResult(page = 1) {

                const params = {
                    page: page,
                    ...this.search_data
                };

                const url = route(this.api_route, params);

                this.showLoading =  true;

                axios.get(url)
                    .then(response => {

                        this.showLoading =  false;

                        this.result_data = response.data;
                    });
            },

            updateParentValue(value) {
                this.$emit('input', value);
            }

        }
    }

</script>
