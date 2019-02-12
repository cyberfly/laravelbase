<v-example-invoice-child
        :invoice_items="invoice.invoice_items"
        :submitted="submitted"
        v-bind:invoice_items.sync="invoice_items"
        v-bind:deleted_invoice_item_ids.sync="deleted_items.invoice_item_ids"
        inline-template>

    <div>
        <!-- Table Head Dark -->
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">Invoice Items</h3>
                <div class="block-options">
                    <div class="block-options-item">
                        <button type="button" class="btn btn-primary" v-on:click="showCreateForm">Add New</button>
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

                        <tr v-for="(item, index) in component_invoice_items">
                            <td class="font-w600">
                                @{{ item.item_name }}
                            </td>
                            <td class="font-w600">
                                @{{ item.item_description }}
                            </td>
                            <td class="font-w600">
                                @{{ item.quantity }}
                            </td>
                            <td class="font-w600">
                                @{{ item.price | toMyCurrency }}
                            </td>
                            <td class="font-w600">
                                @{{ item.amount | toMyCurrency }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button v-on:click="showEditForm(index)" type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                    <button v-on:click="showDeleteForm(index)" type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete">
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
                                @{{ subtotal | toMyCurrency }}
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
        <div class="modal fade" id="invoice-item-modal" tabindex="-1" role="dialog" aria-labelledby="invoice-item-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form @submit.prevent="handleSubmit">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">@{{ modal_title }}</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content">

                                <v-validation-alert :submitted="component_submitted"></v-validation-alert>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <v-text
                                                    v-model="item_data.item_name"
                                                    :field_name="'item_name'"
                                                    :label="'Item Name'"
                                                    :rules="'required'"
                                            ></v-text>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <v-text
                                                    v-model="item_data.item_description"
                                                    :field_name="'item_description'"
                                                    :label="'Item Description'"
                                                    :rules="'required'"
                                            ></v-text>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <v-text
                                                    v-model="item_data.quantity"
                                                    :field_name="'quantity'"
                                                    :label="'Quantity'"
                                                    :rules="'required|decimal'"
                                            ></v-text>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <v-money
                                                    v-model="item_data.price"
                                                    :field_name="'price'"
                                                    :label="'Price'"
                                                    :rules="'required'"
                                            ></v-money>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input :value="amount | toMyCurrency"
                                                   readonly="readonly" type="amount"
                                                   name="amount" ref="amount"
                                                   class="form-control"
                                                   id="amount" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="block-content block-content-full text-right bg-light">
                                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-sm btn-primary">@{{ submit_label }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END Fade In Block Modal -->
    </div>

</v-example-invoice-child>