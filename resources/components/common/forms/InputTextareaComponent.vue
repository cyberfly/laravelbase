<template>
    <div>
        <label :for="id">{{ label }} <span v-if="isRequired" class="text-danger">*</span></label>
        <textarea
                :name="field_name"
                :value="transformInputValue"
                :id="id"
                :placeholder="placeholder"
                :readonly="readonly"
                @input="updateParentValue($event.target.value)"
                v-validate="getValidationRules()"
                :data-vv-as="label"
                class="form-control"
                :class="{ 'is-invalid': errors.has(field_name) }"
                :rows="rows"></textarea>
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
            rows: {
                default: 5,
                type: Number
            },
            rules: {
                default: '',
                type: String
            },
            transform: {
                default: null,
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

            },

            transformInputValue() {
                return this.transformValue(this.value);
            },

        },
        methods: {

            getValidationRules() {
                return this.rules;
            },

            transformValue(value) {

                if (value) {

                    if (this.transform === 'uppercase') {
                        return value.toUpperCase();
                    }

                    if (this.transform === 'lowercase') {
                        return value.toLowerCase();
                    }
                }

                return value;

            },

            updateParentValue(value) {

                let transform_value = this.transformValue(value);

                this.$emit('input', transform_value);
            }
        }
    }

</script>
