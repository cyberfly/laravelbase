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

            // listen for new value from parent component

            value: function (value, old_value) {
                if (value !== old_value) {
                    this.amount = value;
                }
            },

            amount (value) {
                this.updateParentValue(value);
            }

        },
        data() {
            return {
                amount: this.value,
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

            getDefaultAmount() {

                let default_amount = null;

                if (this.value !== null) {
                    default_amount = this.value;
                }

                return default_amount;
            },

            getValidationRules() {
                return this.rules;
            },

            updateParentValue(value) {

                this.$emit('input', value);
            }
        }
    }
</script>