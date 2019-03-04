<template>
    <div>
        <label :for="id">{{ label }} <span v-if="isRequired" class="text-danger">*</span></label>
        <input type="text"
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
            }
        },
        mounted () {

            const isUnique = (value) => {

                const query = {
                    unique_key: this.field_name,
                    unique_value: value,
                    except_key: this.except_key,
                    except_value: this.except_value,
                };

                return axios
                    .post(route(this.api_route, query), { email: value })
                    .then((response) => {

                        return {
                            valid: response.data.data.valid,
                            data: {
                                message: response.data.data.message
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

            }
        },
        methods: {

            getValidationRules() {
                return this.rules + '|unique';
            },

            updateParentValue(value) {

                this.$emit('input', value);
            }
        }
    }

</script>
