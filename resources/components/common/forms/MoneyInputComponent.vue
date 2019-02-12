<template>
    <div>
        <label :for="id">{{ label }} <span v-if="isRequired" class="text-danger">*</span></label>
        <vue-autonumeric
                v-model="amount"
                :name="field_name"
                :options="autonumeric_options"
                v-validate="getValidationRules()"
                :data-vv-as="label"
                :id="id"
                :autocomplete="'off'"
                class="form-control"
                :class="{ 'is-invalid': errors.has(field_name) }"
        ></vue-autonumeric>
        <div class="invalid-feedback">{{ errors.first(field_name) }}</div>
    </div>
</template>

<script>
    import VueAutonumeric from 'vue-autonumeric/src/components/VueAutonumeric.vue';

    export default {
        inject: ['$validator'],
        components: {
            VueAutonumeric,
        },
        props: {
            value: {},
            precision: {
                default: 2
            },
            currency_symbol: {
                default: 'RM '
            },
            field_name: {
                required: true,
            },
            label: {
                required: true,
            },
            field_id: {
                default: null,
                type: String,
            },
            rules: {
                default: '',
                type: String
            }
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

            isRequired() {

                if (!this.rules) {
                    return false;
                }

                return (typeof this.rules === 'string')
                    ? this.rules.includes('required')
                    : this.rules['required'];

            }
        },
        watch: {

            /*
            we manually set the amount from parent v-model value
            because vue-autonumeric cant directly set the value
            */

            value (value, old_value) {
                this.amount = value;
            },

            amount (value) {
                this.updateParentValue(value);
            }
        },
        data() {
            return {
                amount: null,
                autonumeric_options: {
                    emptyInputBehavior: 'null',
                    digitGroupSeparator: ',',
                    decimalCharacter: '.',
                    currencySymbol: this.currency_symbol,
                    minimumValue: '0',
                    decimalPlaces: this.precision,
                }
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