<template>
    <div>
        <label :for="id">{{ label }} <span v-if="isRequired" class="text-danger">*</span></label>
        <input type="text"
               :name="field_name"
               :value="value"
               :id="id"
               :placeholder="placeholder"
               @input="updateParentValue($event.target.value)"
               v-validate="getValidationRules()"
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
                required: true
            },
            label: {
                required: true
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
                return this.rules;
            },

            updateParentValue(value) {

                this.$emit('input', value);
            }
        }
    }

</script>
