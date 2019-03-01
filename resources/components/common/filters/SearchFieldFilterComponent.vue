<template>
    <div>
        <label for="">{{ search_label }}</label>

        <div class="input-group">

            <input type="text"
                   v-model="search_data.search"
                   class="form-control"
                   :placeholder="search_placeholder"
                   aria-label="">

            <div v-if="true" class="input-group-append">

                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-search mr-1"></i> <span class="sr-only">Toggle Dropdown</span>
                </button>

                <div class="dropdown-menu dropdown-menu-right">
                    <a v-for="type in search_option_types"
                       @click="setSearchType(type.key)" class="dropdown-item" >
                        <i class="fa fa-fw fa-pencil-alt mr-1"></i> {{ type.label }}
                    </a>
                </div>

            </div>

        </div>
    </div>
</template>

<script>

    export default {
        props: {
            value: {},
            label: {
                type: String,
                default: 'Keyword'
            },
            placeholder: {
                type: String,
                default: 'Enter the'
            },
            search_options: {
                type: Array,
                default: function () {
                    return [];
                },
            }
        },
        computed: {

            search_option_types: function () {

                const default_option = {
                    key: null,
                    label: this.label,
                };

                let option_types = [...this.search_options, default_option];

                return option_types;

            },

        },
        data () {
            return {
                search_data: this.value,
                search_label: this.label,
                search_placeholder: this.getDefaultPlaceholder(),
            }
        },
        created () {

            // set the search label if search_type is set on load

            if (this.search_data.search_type) {

                let label = this.getSearchLabel(this.search_data.search_type);

                this.search_label = label;
            }
        },
        watch:{

            search_data: {
                handler(value){
                    this.updateParentValue(value);
                },
                deep: true
            },

        },
        methods: {

            getDefaultPlaceholder() {

                return this.placeholder + ' ' + this.label;
            },

            setSearchType(type=null) {

                Vue.set(this.search_data, 'search_type', type);

                let label = this.getSearchLabel(type);

                this.search_label = label;

                this.search_placeholder = this.placeholder + ' ' + label;
            },

            getSearchLabel(search_type) {

                let label = this.search_label;

                let search_type_option = _.find(this.search_option_types, { key: search_type });

                if (search_type_option) {
                    label = search_type_option.label;
                }

                return label;
            },

            updateParentValue(value) {

                this.$emit('input', value);
            }

        }
    }

</script>
