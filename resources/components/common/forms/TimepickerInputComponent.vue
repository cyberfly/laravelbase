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
                    <i class="far fa-clock">
                        <span aria-hidden="true" class="sr-only">Toggle</span>
                    </i>
                </button>
                <button v-if="show_clear" class="btn btn-outline-secondary" type="button" title="Clear" data-clear>
                    <i class="fa fa-times">
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
                default: 'H:i',
                type: String
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

            }
        },
        data () {
            return {
                date_input: this.value,
                date: new Date(),
                config: {
                    wrap: true,
                    altFormat: this.format,
                    altInput: true,
                    enableTime: true,
                    enableSeconds: true,
                    noCalendar: true,
                    dateFormat: 'Y-m-d H:i',
                },
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