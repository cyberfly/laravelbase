<template>
    <div>
        <label :for="id">{{ label }} <span v-if="isRequired" class="text-danger">*</span></label>
        <multiselect
                v-model="selected_options"
                :options="options"
                @input="updateSelectedOptions"
                :multiple="multiple"
                :searchable="searchable"
                :loading="isLoading"
                :close-on-select="true"
                :show-labels="false"
                :hide-selected="false"
                :track-by="value_key"
                :label="label_key"
                :disabled="readonly"
                v-validate.disable="getValidationRules()"
                :data-vv-name="field_name"
                :data-vv-value-path="field_name"
                :data-vv-as="label"
                :class="{ 'is-invalid': errors.has(field_name) }"
                :placeholder="placeholder">
        </multiselect>
        <div class="invalid-feedback">{{ errors.first(field_name) }}</div>
    </div>
</template>

<script>

    export default {
        inject: ['$validator'],
        props: {
            value: {},
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
            value_key: {
                required: true
            },
            label_key: {
                required: true
            },
            field_name: {
                required: true
            },
            label: {
                required: true
            },
            readonly: {
                default: false,
            },
            field_id: {
                default: null,
                type: String,
            },
            field_placeholder: {
                default: null,
                type: String,
            },
            multiple: {
                default: false
            },
            searchable: {
                default: true
            },
            rules: {
                default: '',
                type: String
            },
        },
        mounted() {

        },
        computed: {

            id: function () {

                // if field id is not set, we use field_name as id
                if (!this.field_id) {
                    return this.field_name;
                }
                else {
                    return this.field_id;
                }
            },

            placeholder: function () {
                // if field_placeholder is not set, we auto created a placeholder
                if (!this.field_placeholder) {
                    return this.trans.get('labels.select') + ' ' + this.label;
                }
                else {
                    return this.field_placeholder;
                }

            },

            isRequired() {

                if (!this.rules) {
                    return false;
                }

                return (typeof this.rules === 'string')
                    ? this.rules.includes('required')
                    : this.rules['required'];

            },

        },
        watch: {

            // listen for new value from parent component

            value: function (value, old_value) {
                if (value !== old_value) {

                    this.state = 'change';

                    this.selected_options = this.getDefaultSelectedOptions();
                }
            },

        },
        data() {

            return {
                options: [],
                selected_options: [],
                submitted: false,
                state: 'init',
                isLoading: false,
            };

        },
        created() {

            this.getAjaxOptions();

        },
        methods: {

            getAjaxOptions() {

                const query = this.api_param;

                this.isLoading = true;

                axios
                    .get(route(this.api_route, query))
                    .then(response => {

                        let ajax_options = response.data.data;

                        if (!this.multiple) {

                            const default_option = {
                                [this.value_key]: null,
                                [this.label_key]: this.placeholder
                            };

                            ajax_options = [default_option, ...ajax_options];
                        }

                        // set new options

                        this.options = ajax_options;

                        // set new selected options

                        this.selected_options = this.getDefaultSelectedOptions();

                        this.isLoading = false;

                    })
                    .catch(function (error) {
                        console.log('error res -->', error);
                    });
            },

            getDefaultSelectedOptions () {

                let selected_options = [];

                // only get the default selected options if value from parent v-model is not null

                if (this.value) {

                    if (this.multiple) {

                        this.value.forEach((value) => {

                            const selected_object = this.getObjectByValue(this.options, this.value_key, value);

                            if (typeof selected_object !== 'undefined') {
                                selected_options.push(selected_object);
                            }

                        });

                    }
                    else {

                        const selected_object = this.getObjectByValue(this.options, this.value_key, this.value);

                        if (typeof selected_object !== 'undefined') {
                            selected_options = selected_object;
                        }
                    }
                }

                return selected_options;
            },

            getObjectByValue(object, property, value) {

                const selected_object = object.find(item => {
                    return item[property] == value;
                });

                return selected_object;
            },

            getValidationRules() {
                return this.rules;
            },

            /*
             1. If multiple set to true, extract selected options id from Vue Multi Select object
             2. If multiple set to false, get the single value
             2. Emit selected options id to parent component
             */

            updateSelectedOptions(options) {

                let selected_options_value = null;

                if (options) {

                    if (this.multiple) {

                        let selected_options_id = [];

                        options.forEach((option) => {
                            selected_options_id.push(option[this.value_key]);
                        });

                        selected_options_value = selected_options_id;

                    }
                    else {
                        selected_options_value = options[this.value_key];
                    }

                }

                // perform validation

                this.$validator.validate(this.field_name);

                // emit value to parent component

                this.updateParentValue(selected_options_value);
            },

            updateParentValue(value) {

                this.$emit('input', value);
            }
        }
    }

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

    .multiselect.is-invalid {
        border: 1px solid #e04f1a;
        border-radius: 0.25rem;
    }

    .multiselect.multiselect--active {
        z-index: 10;
    }

</style>