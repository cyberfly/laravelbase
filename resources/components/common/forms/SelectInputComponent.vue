<template>
    <div>
        <label :for="id">{{ label }} <span v-if="isRequired" class="text-danger">*</span></label>
        <select
                :name="field_name"
                :id="id"
                @input="updateParentValue($event.target.value)"
                v-validate="getValidationRules()"
                class="form-control"
                :class="{ 'is-invalid': errors.has(field_name) }"
                :multiple="multiple"
        >
            <option v-if="!multiple" :value="''">Select {{ label }}</option>
            <option v-for="item in items" :value="item[value_key]" >{{ item[label_key] }}</option>
        </select>
        <div class="invalid-feedback">{{ errors.first(field_name) }}</div>
    </div>
</template>

<script>

    export default {
        inject: ['$validator'],
        props: {
            value: {},
            items: {
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
            id: {
                default: this.field_name,
            },
            multiple: {
                default: false
            },
            rules: {
                default: '',
                type: String
            },
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
