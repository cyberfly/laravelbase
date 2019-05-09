<template>
    <div>
        <label :for="id">{{ label }} <span v-if="isRequired" class="text-danger">*</span></label>
        <input type="text"
               :name="field_name"
               :value="transformInputValue"
               :id="id"
               :placeholder="placeholder"
               :readonly="readonly"
               @input="updateParentValue($event.target.value)"
               v-validate="getValidationRules()"
               :data-vv-as="label"
               data-vv-delay="100"
               class="form-control"
               :class="{ 'is-invalid': errors.has(field_name) }"
               ref="input">
        <div class="invalid-feedback">{{ errors.first(field_name) }}</div>
    </div>
</template>

<script>

    import { Validator } from 'vee-validate';

    export default {
        inject: ['$validator'],
        props: {
            value: {},
            api_route: {
                required: true,
                type: String,
            },
            field_name: {
                required: true,
            },
            except_key: {
                default: 'id',
                type: String,
            },
            except_value: {
                default: null,
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
            },
            transform: {
                default: null,
                type: String
            }
        },
        created () {

            const isUnique = (value, [unique_key, except_key, except_value]) => {

                const query = {
                    unique_key: unique_key,
                    unique_value: value,
                    except_key: except_key,
                    except_value: except_value,
                };

                return axios
                    .post(route(this.api_route), query)
                    .then((response) => {

                        let validated_message = response.data.data.message;

                        if (validated_message) {
                            validated_message = validated_message.replace(unique_key, this.label);
                        }

                        return {
                            valid: response.data.data.valid,
                            data: {
                                message: validated_message
                            }
                        };
                    });

            };

            Validator.extend("unique", {
                validate: isUnique,
                getMessage: (field, params, data) => data.message
            });

        },
        data () {

            return {}

        },
        computed: {

            getDefaultUniqueKey() {

            },

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

                let validation_rules = {
                    required: this.isRequired,
                    unique: [
                        this.field_name,
                        this.except_key,
                        this.except_value
                    ]
                };

                // append another validation rules

                this.rules.split("|").forEach(function (rule) {
                    validation_rules[rule] = true;
                });

                return validation_rules;

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
