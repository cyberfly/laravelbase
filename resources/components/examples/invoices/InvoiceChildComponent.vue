<script>

    export default {
        props: {
            invoice_items: {
                required: true,
            },
            submitted: {
                default: false,
            }
        },
        mounted () {

        },
        data () {
            return {
                component_invoice_items: [...this.invoice_items],
                deleted_invoice_items: [],
                item_data: this.getDefaultItemData(),
                component_submitted: false,
                current_action: 'create',
                current_index: null,
                submit_label: 'Create',
                modal_title: 'New Invoice Item',
            };
        },
        created () {

        },
        computed: {
            amount: function () {

                let amount = parseFloat(this.item_data.quantity) * parseFloat(this.item_data.price);

                if (isNaN(amount)) {
                    amount = 0;
                }

                return amount;
            },
            subtotal: function () {

                const subtotal = this.component_invoice_items.reduce(function(result, item) {
                    return result + parseFloat(item.amount);
                }, 0);

                return subtotal;
            },
            deleted_invoice_item_ids: function () {

                // filter, only get deleted item with ids for backend usage
                // get the deleted item ids from filtered result

                const deleted_invoice_item_ids = this.deleted_invoice_items.filter(function(item) {
                    return item.id;
                }).map(item => item.id);

                return deleted_invoice_item_ids;
            },
        },
        methods: {

            getDefaultItemData() {

                return {
                    id: null,
                    invoice_id: null,
                    item_name: null,
                    item_description: null,
                    quantity: null,
                    price: null,
                    amount: 0,
                };

            },

            /*
            * Reset previous validation error each time open a new Modal form
            * */
            resetValidation() {
                this.$validator.reset();
            },

            showCreateForm() {

                this.current_action = 'create';

                // reset form to initial value

                this.item_data = this.getDefaultItemData();
                this.resetValidation();

                // set submit label and modal title
                this.submit_label = 'Create';
                this.modal_title = 'New Invoice Item';

                this.openModal();
            },

            showEditForm(index) {

                this.current_action = 'edit';

                this.current_index = index;

                // get item data from component invoice items array

                let copied_item_data = Object.assign({}, this.component_invoice_items[index]);

                this.item_data = copied_item_data;

                // reset validation

                this.resetValidation();

                // set submit label and modal title
                this.submit_label = 'Update';
                this.modal_title = 'Edit Invoice Item';

                this.openModal();
            },

            showDeleteForm(index) {

                this.current_index = index;

                this.$swal({
                    title: 'Are you sure?',
                    text: 'You can\'t revert your action',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    showLoaderOnConfirm: true
                }).then((result) => {

                    if(result.value) {
                        this.$swal('Deleted', 'You successfully deleted this item', 'success');
                        this.destroy();
                    } else {

                    }
                });

            },

            openModal() {
                $('#invoice-item-modal').modal('show');
            },

            closeModal() {
                $('#invoice-item-modal').modal('hide');
            },

            /*
            * Handle modal submission for New and Edit
            * */
            handleSubmit(e) {

                this.component_submitted = true;

                this.$validator.validate().then(valid => {
                    if (valid) {

                        if (this.current_action === 'create') {
                            this.store();
                        }
                        else if (this.current_action === 'edit') {
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
            * Assign computed amount to item_data.amount
            * */
            setItemAmount() {

                // set amount from computed

                this.item_data.amount = this.amount;

            },

            /*
            * New row created by v-for must be re-init for tooltip to work
            * */

            reinitTooltip() {
                Vue.nextTick(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            },

            store() {

                this.setItemAmount();

                this.component_invoice_items.push(this.item_data);

                this.reinitTooltip();

                this.closeModal();

                this.updateParent();
            },

            update() {

                this.setItemPriceAmount();

                Vue.set(this.component_invoice_items, this.current_index, this.item_data);

                this.closeModal();

                this.updateParent();

            },

            destroy() {

                let deleted_item = this.component_invoice_items[this.current_index];

                // remove item from component_invoice_items array

                this.$delete(this.component_invoice_items, this.current_index);

                // add the item into deleted_invoice_items array

                this.deleted_invoice_items.push(deleted_item);

                this.updateParent();

                this.updateParentDeletedItems();
            },

            /*
            * Update the parent component the value of latest component_invoice_items after Create / Update / Delete operation
            * */
            updateParent() {
                this.$emit('update:invoice_items', this.component_invoice_items);
            },

            /*
            * Update the parent component the value of latest deleted invoice items id
            * */
            updateParentDeletedItems() {

                this.$emit('update:deleted_invoice_item_ids', this.deleted_invoice_item_ids);
            }
        }
    }
</script>