<template>
    <div>
        <label :for="id">{{ label }} <span v-if="isRequired" class="text-danger">*</span></label>
        <div class="input-group">

            <flat-pickr
                    v-model="date_input"
                    :config="config"
                    :name="field_name"
                    v-validate="getValidationRules()"
                    :data-vv-as="label"
                    class="form-control"
                    :class="{ 'is-invalid': errors.has(field_name) }"
            ></flat-pickr>

            <div class="input-group-append">
                <button v-if="show_toggle" class="btn btn-outline-dark" type="button" title="Toggle" data-toggle>
                    <i class="far fa-calendar-alt">
                        <span aria-hidden="true" class="sr-only">Toggle</span>
                    </i>
                </button>
                <button v-if="show_clear" class="btn btn-outline-secondary" type="button" title="Clear" data-clear>
                    <i class="far fa-calendar-minus">
                        <span aria-hidden="true" class="sr-only">Clear</span>
                    </i>
                </button>
            </div>
        </div>
        <div class="invalid-feedback">{{ errors.first(field_name) }}</div>
    </div>
</template>

<script>

    import 'flatpickr/dist/flatpickr.css';

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
            format: {
                default: 'd/m/Y',
                type: String
            },
            min_date: {
                default: null,
            },
            max_date: {
                default: null,
            },
            disabled_date: {
                type: Array,
                default: function () {
                    return [];
                },
            },
            id: {
                default: '',
                type: String
            },
            show_toggle: {
                default: true,
                type: Boolean
            },
            show_clear: {
                default: false,
                type: Boolean
            },
            rules: {
                default: '',
                type: String
            },
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

            config() {

                let date_config = {
                    wrap: true,
                    altFormat: this.format,
                    altInput: true,
                    dateFormat: 'Y-m-d',
                };

                if (this.min_date) {
                    date_config['minDate'] = this.min_date;
                }

                if (this.max_date) {
                    date_config['maxDate'] = this.max_date;
                }

                if (this.disabled_date.length > 0) {
                    date_config['disable'] = this.disabled_date;
                }

                return date_config;
            },

        },
        data () {
            return {
                date_input: this.value,
                date: new Date(),
            }
        },
        watch:{
            date_input (value) {
                this.updateParentValue(value);
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