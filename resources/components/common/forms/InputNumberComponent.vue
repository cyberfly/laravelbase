<template>
    <div>
        <label :for="id">{{ label }} <span v-if="isRequired" class="text-danger">*</span></label>
        <input type="number"
               :name="field_name"
               :value="value"
               :id="id"
               :placeholder="placeholder"
               :readonly="readonly"
               @input="updateParentValue($event.target.value)"
               v-validate="getValidationRules()"
               :data-vv-as="label"
               class="form-control"
               :class="{ 'is-invalid': errors.has(field_name) }"
               ref="input">
        <div class="invalid-feedback">{{ errors.first(field_name) }}</div>
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
                required: true,
            },
            readonly: {
                default: false,
            },
            placeholder: {
                default: '',
            },
            id: {
                default: this.field_name,
            },
            rules: {
                default: '',
                type: String
            }
        },
        mounted() {

        },
        computed: {

            isRequired() {

                if (!this.rules) {
                    return false;
                }

                return (typeof this.rules === 'string')
                    ? this.rules.includes('required')
                    : this.rules['required'];

            }
        },
        methods: {

            getValidationRules() {

                let default_rules = 'numeric';

                if (this.rules) {
                    default_rules = default_rules + '|' + this.rules;
                }

                return default_rules;
            },

            updateParentValue(value) {

                this.$emit('input', value);
            }
        }
    }

</script>
