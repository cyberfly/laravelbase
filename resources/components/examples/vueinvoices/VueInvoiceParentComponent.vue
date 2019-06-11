<template>
    <div>

        <!-- parent component form -->

        <div>

            <v-validation-alert :submitted="submitted"></v-validation-alert>

            <div class="row">
                <div class="col-lg-4">

                </div>
                <div class="col-lg-8">

                    <div class="form-group">
                        <v-text
                                v-model="invoice_data.invoice_number"
                                :field_name="'invoice_number'"
                                :label="'Invoice number'"
                                :rules="'required'"
                        ></v-text>
                    </div>

                    <div class="form-group">
                        <v-text
                                v-model="invoice_data.po_number"
                                :field_name="'po_number'"
                                :label="'PO number'"
                                :rules="'required'"
                        ></v-text>
                    </div>

                    <div class="form-group">
                        <v-date
                                v-model="invoice_data.invoice_date"
                                :field_name="'invoice_date'"
                                :label="'Invoice Date'"
                                :rules="'required'"
                        ></v-date>
                    </div>

                    <div class="form-group">
                        <v-date
                                v-model="invoice_data.payment_due"
                                :field_name="'payment_due'"
                                :label="'Payment Due'"
                                :rules="'required'"
                        ></v-date>
                    </div>

                </div>
            </div>

            <!--include child component (Invoice Items table and modal)-->

            <v-example-vueinvoice-child
                    :invoice_items="invoice.invoice_items"
                    :isDraft="isDraft"
                    :submitted="submitted"
                    v-bind:invoice_items.sync="invoice_items"
                    v-bind:deleted_invoice_item_ids.sync="deleted_items.invoice_item_ids"
            ></v-example-vueinvoice-child>

            <div class="form-group">
                <button v-if="isDraft" @click="save()" type="button" class="btn btn-secondary">Save</button>
                <button v-if="isDraft" @click="submit()" type="button" class="btn btn-primary">Submit</button>
            </div>

        </div>

    </div>
</template>
<script>

    export default {
        props: {
            invoice: {
                required: true,
            }
        },
        mounted() {

        },
        created () {

        },
        computed: {

            isDraft: function () {

                if (this.publish_status !== 'DRAFT') {
                    return false;
                }

                return true;
            },

            /*
             * Customize the invoice data before submit into API
             * */
            finalInvoiceData: function () {

                let invoice_data = {...this.invoice_data};

                // delete the invoice_data nested invoice_items to prevent confusion on backend
                delete invoice_data.invoice_items;

                const data = {
                    'invoice': invoice_data,
                    'invoice_items': this.invoice_items,
                    'deleted_items': this.deleted_items,
                    'submitted': this.submitted
                };

                return data;
            },

        },
        data() {
            return {
                invoice_data: {...this.invoice},
                invoice_items: [...this.invoice.invoice_items],
                deleted_items: {
                  invoice_item_ids: [],
                },
                submitted: false,
                publish_status: this.invoice.publish_status,
            };
        },
        methods: {

            save() {

                this.submitted = false;

                this.handleSubmit();
            },

            submit() {

                this.submitted = true;

                this.handleSubmit();

            },

            handleSubmit() {

                console.log('invoice: ', JSON.stringify(this.invoice_data, null, 2));

                this.$validator.validate().then(valid => {
                    if (valid) {

                        // if everything okay, submit the form

                        // if invoice id null, we create a new invoice
                        if (!this.invoice_data.id) {
                            this.store();
                        }
                        else {
                            // if invoice id already exist, we just update the invoice
                            this.update();
                        }

                    }
                    else {
                        // scroll to top

                        window.scrollTo(0,0);
                    }
                });

            },

            store() {

                this.$showLoading();

                console.log('submitting into API', this.finalInvoiceData);

                axios
                    .post(route('examples.vueinvoices.store'), this.finalInvoiceData)
                    .then(response => {

                        this.$hideLoading();

                        console.log('res -->', response.data.data);

                        // set publish_status

                        this.publish_status = response.data.data.publish_status;

                        const created_invoice = response.data.data;

                        // success notification

                        this.$showSuccessCreated('Invoice', route('examples.vueinvoices.edit', created_invoice.id));

                    })
                    .catch(function (error) {
                        console.log('error res -->', error);
                    });
            },

            update() {

                this.$showLoading();

                console.log('submitting into API', this.finalInvoiceData);

                axios
                    .put(route('examples.vueinvoices.update', this.invoice_data.id), this.finalInvoiceData)
                    .then(response => {

                        this.$hideLoading();

                        console.log('res -->', response.data.data);

                        // set publish_status

                        this.publish_status = response.data.data.publish_status;

                        const updated_invoice = response.data.data;

                        // success notification

                        this.$showSuccessUpdated('Invoice');

                    })
                    .catch(function (error) {
                        console.log('error res -->', error);
                    });
            }
        }
    }
</script>