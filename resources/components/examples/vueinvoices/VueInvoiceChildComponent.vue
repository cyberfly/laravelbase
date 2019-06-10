<template>
    <div>
        <!-- Table Head Dark -->
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">Invoice Items</h3>
                <div class="block-options">
                    <div class="block-options-item">
                        <button v-if="isDraft" type="button" class="btn btn-primary" @click="showCreateForm">Add New</button>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <table class="table table-vcenter">
                    <thead class="thead-dark">
                    <tr>
                        <th>Item Name</th>
                        <th class="d-none d-sm-table-cell">Item Description</th>
                        <th class="d-none d-sm-table-cell">Quantity</th>
                        <th class="d-none d-sm-table-cell">Price (RM)</th>
                        <th class="d-none d-sm-table-cell">Amount (RM)</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(item, index) in component_invoice_items" :key="index" >
                        <td class="font-w600">
                            {{ item.item_name }}
                        </td>
                        <td class="font-w600">
                            {{ item.item_description }}
                        </td>
                        <td class="font-w600">
                            {{ item.quantity }}
                        </td>
                        <td class="font-w600">
                            {{ item.price | toMyCurrency }}
                        </td>
                        <td class="font-w600">
                            {{ item.amount | toMyCurrency }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button v-if="isDraft" @click="showEditForm(index)" type="button" class="btn btn-sm btn-primary" v-b-tooltip.hover title="Edit">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                                <button v-if="isDraft" @click="showDeleteForm(index)" type="button" class="btn btn-sm btn-danger" v-b-tooltip.hover title="Delete">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    </tbody>
                    <tfoot class="thead-dark">
                    <tr>
                        <td colspan="3">

                        </td>
                        <td>
                            Subtotal
                        </td>
                        <td>
                            {{ subtotal | toMyCurrency }}
                        </td>
                        <td>

                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END Table Head Dark -->

        <!-- Fade In Block Modal -->

        <b-modal ref="formModalRef"
                 size="lg"
                 :title="modal_title"
                 :header-class="'bg-primary-dark'"
                 :header-text-variant="'light'"
                 :footer-class="'bg-light'"
        >
            <div class="d-block">

                <div class="form-row">

                    <div class="form-group col-md-6">

                        <v-text
                                v-model="item_data.item_name"
                                :field_name="'item_name'"
                                :label="'Item Name'"
                                :rules="'required'"
                        ></v-text>

                    </div>

                    <div class="form-group col-md-6">

                        <v-text
                                v-model="item_data.item_description"
                                :field_name="'item_description'"
                                :label="'Item Description'"
                                :rules="'required'"
                        ></v-text>

                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-lg-4">

                        <v-text
                                v-model="item_data.quantity"
                                :field_name="'quantity'"
                                :label="'Quantity'"
                                :rules="'required|decimal'"
                        ></v-text>

                    </div>

                    <div class="form-group col-lg-4">

                        <v-money
                                v-model="item_data.price"
                                :field_name="'price'"
                                :label="'Price'"
                                :rules="'required'"
                        ></v-money>

                    </div>

                    <div class="form-group col-lg-4">

                        <label for="amount">Amount</label>
                        <input :value="amount | toMyCurrency"
                               readonly="readonly" type="amount"
                               name="amount" ref="amount"
                               class="form-control"
                               id="amount" >

                    </div>

                </div>

            </div>
            <div slot="modal-footer">
                <button @click="cancel()" type="button" class="btn btn-sm btn-light">Cancel</button>
                <button @click="handleSubmit()" type="submit" class="btn btn-sm btn-primary">{{ submit_label }}</button>
            </div>
        </b-modal>

        <!-- END Fade In Block Modal -->
    </div>
</template>
<script>

    export default {
        props: {
            invoice_items: {
                required: true,
            },
            isDraft: {
                required: true,
                type: Boolean,
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
        watch:{

            /*
             * Assign computed amount to this.item_data.amount
             * */

            amount (value) {
                this.item_data.amount = value;
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
                this.$refs.formModalRef.$validator.reset();
            },

            showCreateForm() {

                this.current_action = 'create';

                // reset form to initial value

                this.item_data = this.getDefaultItemData();
                this.resetValidation();

                // set submit label and modal title
                this.submit_label = 'Create';
                this.modal_title = 'New Invoice Item';

                this.showModal();
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

                this.showModal();
            },

            showDeleteForm(index) {

                this.current_index = index;

                this.destroy();

            },

            cancel() {
                this.hideModal();
            },

            showModal() {
                this.$refs.formModalRef.show();
            },

            hideModal() {
                this.$refs.formModalRef.hide();
            },

            /*
            * Handle modal submission for New and Edit
            * */
            handleSubmit(e) {

                this.component_submitted = true;

                this.$refs.formModalRef.$validator.validate().then(valid => {
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

            store() {

                this.component_invoice_items.push(this.item_data);

                this.hideModal();

                this.updateParent();
            },

            update() {

                Vue.set(this.component_invoice_items, this.current_index, this.item_data);

                this.hideModal();

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