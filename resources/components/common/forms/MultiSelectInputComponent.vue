<template>
    <div>
        <label :for="id">{{ label }} <span v-if="isRequired" class="text-danger">*</span></label>
        <multiselect
                v-model="selected_options"
                :options="options"
                @input="updateSelectedOptions"
                :multiple="multiple"
                :searchable="searchable"
                :close-on-select="true"
                :show-labels="false"
                :hide-selected="true"
                :track-by="value_key"
                :label="label_key"
                v-validate="getValidationRules()"
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
            options: {
                type: Array
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
                    return 'Select ' + this.label;
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

            }
        },
        data() {

            return {
                selected_options: [],
                submitted: false
            }

        },
        methods: {

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

                if (this.multiple) {

                    let selected_options_id = [];

                    options.forEach((option) => {
                        selected_options_id.push(option[this.value_key]);
                    });

                    selected_options_value = selected_options_id;

                }
                else {
                    selected_options_value = options;
                }

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

</style>