<script>

    export default {
        props: {
            invoice: {
                required: true
            }
        },
        mounted() {
            console.log('invoice prop ->', this.invoice);
        },
        provide() {
            return {
                parentValidator: this.$validator,
            }
        },
        data() {
            return {
                invoice_data: {...this.invoice},
                invoice_items: [...this.invoice.invoice_items],
                deleted_items: {
                  invoice_item_ids: [],
                },
                submitted: false
            };
        },
        methods: {

            handleSubmit(e) {

                this.submitted = true;

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

            /*
            * Customize the invoide data before submit into API
            * */
            getInvoiceData() {

                let invoice_data = {...this.invoice_data};

                // delete the invoice_data nested invoice_items to prevent confusion on backend
                delete invoice_data.invoice_items;

                const data = {
                    'invoice': invoice_data,
                    'invoice_items': this.invoice_items,
                    'deleted_items': this.deleted_items,
                };

                return data;
            },

            store() {

                const data = this.getInvoiceData();

                console.log('submitting into API', data);

                axios
                    .post(route('examples.invoices.store'), data)
                    .then(response => {

                        console.log('res -->', response.data.data);

                        const created_invoice = response.data.data;

                        // success notification

                        this.$swal({
                            title: 'Good job!',
                            text: 'Invoice was successfully created!',
                            type: 'success',
                            confirmButtonText: 'Ok'
                        }).then(function() {
                            // redirect to

                            window.location = route('examples.invoices.edit', created_invoice.id);
                        });

                    })
                    .catch(function (error) {
                        console.log('error res -->', error);
                    });
            },

            update() {

                const data = this.getInvoiceData();

                console.log('submitting into API', data);

                axios
                    .put(route('examples.invoices.update', this.invoice_data.id), data)
                    .then(response => {

                        console.log('res -->', response.data.data);

                        const updated_invoice = response.data.data;

                        // success notification

                        this.$swal({
                            title: 'Good job!',
                            text: 'Invoice was successfully updated!',
                            type: 'success',
                            confirmButtonText: 'Ok'
                        }).then(function() {

                        });

                    })
                    .catch(function (error) {
                        console.log('error res -->', error);
                    });
            }
        }
    }
</script>